<?php
require_once '../config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['class'])) {
    $params = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'class' => $_POST['class'],
        'ip' => $_SERVER['REMOTE_ADDR'],
    ];

    $sql = "SELECT id FROM votes WHERE ip = :ip OR email = :email";
    $prepared_query = $link->prepare($sql);
    $prepared_query->execute([
        'ip' => $params['ip'],
        'email' => $params['email']
    ]);
    $res = $prepared_query->fetchColumn(0);
    if (!$res) {
        $sql = "INSERT INTO votes(name, email, class, ip) VALUES (:name, :email, :class, :ip)";
        $prepared_query = $link->prepare($sql);
        $res = $prepared_query->execute($params);

        echo json_encode([
            'error' => 0,
            'message' => 'Спасибо за ваш голос!'
        ]);
    } else {
        echo json_encode([
            'error' => 1,
            'message' => 'Вы уже голосовали!'
        ]);
    }
} else {
    echo json_encode([
        'error' => 1,
        'message' => 'Не все поля заполнены',
    ]);
}

