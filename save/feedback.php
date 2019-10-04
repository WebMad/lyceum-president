<?php

require_once '../config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
    $params = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message'],
    ];

    if (time() - $_SESSION['last_feedback'] > 300) {
        $sql = "INSERT INTO feedbacks(name, email, message) VALUES (:name, :email, :message)";
        $prepared_query = $link->prepare($sql);
        $res = $prepared_query->execute($params);

        $_SESSION['last_feedback'] = time();

        echo json_encode([
            'error' => 0,
            'message' => 'Спасибо за ваше сообщение!'
        ]);
    } else {
        echo json_encode([
            'error' => 1,
            'message' => 'Оставлять сообщение можно раз в 5 минут! Это сделано с целью избежать спама.'
        ]);
    }
} else {
    echo json_encode([
        'error' => 1,
        'message' => 'Не все поля заполнены',
    ]);
}