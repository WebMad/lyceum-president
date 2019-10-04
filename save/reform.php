<?php
require_once '../config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
    $params = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message'],
    ];

    if (time() - $_SESSION['last_idea'] > 300) {
        $sql = "INSERT INTO reforms(name, email, message) VALUES (:name, :email, :message)";
        $prepared_query = $link->prepare($sql);
        $res = $prepared_query->execute($params);

        $_SESSION['last_idea'] = time();

        echo json_encode([
            'error' => 0,
            'message' => 'Спасибо за вашу идею!'
        ]);
    } else {
        echo json_encode([
            'error' => 1,
            'message' => 'Предлагать идеи можно раз в 5 минут! Это сделано с целью избежать спама.'
        ]);
    }
} else {
    echo json_encode([
        'error' => 1,
        'message' => 'Не все поля заполнены',
    ]);
}