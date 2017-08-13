<?php
require_once('connect.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = formUserFromPost();
    $email = $_POST['email'];

    $existing_user = db_findUserByEmail($DBH, $email);

    if (empty($existing_user)) {
        $user_id = db_insertUser($DBH, $user);

    } else {
        $user_id = $existing_user[0]['id'];
    }

    if (!$user_id) {
        echo 'Ошибка формирования заказа';
        return;
    }

    $order = formOrderFromPost($user_id);
    $order_id = db_insertOrder($DBH, $order);

    if ($order_id < 1) {
        echo 'Ошибка формирования заказа';
        return;
    }
    echo 'Ваш заказ получен';

    $order_count = composeOrdersCountString($DBH, $user_id);
    $order_address = $order[1];
    $mail_content = composeLetter($order_address, $order_id, $order_count);
    $mail_result = mail($email, 'Ваш заказ', $mail_content);
    if ($mail_result) {
        echo "<br>На ваш адрес ($email) отправлено письмо";
    }

}