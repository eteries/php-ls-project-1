<?php

/**
 * Добавляет в БД нового пользователя при помощи подготовленного выражения
 * и переданного массива данных. При успехе возвращает ID последней записи.
 *
 * @param pdo $DBH
 * @param array $data
 *
 * @return int|string
 */
function db_insertUser(pdo $DBH, array $data)
{
    $STH = $DBH->prepare("INSERT INTO users (name, email, phone) values (?, ?, ?)");
    $STH->execute($data);
    return $DBH->lastInsertId();
}

/**
 * Добавляет в БД новый заказ при помощи подготовленного выражения
 * и переданного массива данных. При успехе возвращает ID последней записи.
 *
 * @param pdo $DBH
 * @param array $data
 *
 * @return int|string
 */
function db_insertOrder(pdo $DBH, array $data)
{
    $STH = $DBH->prepare("INSERT INTO orders (user_id, address, comment, payment, callback) values (?, ?, ?, ?, ?)");
    $STH->execute($data);
    return $DBH->lastInsertId();
}

/**
 * Ищет в БД пользователя с переданым в качестве параметра email.
 * Возвращает массив с данными пользователя, либо пустой при неудаче
 *
 * @param pdo $DBH
 * @param string $email
 *
 * @return array
 */
function db_findUserByEmail(pdo $DBH, string $email) : array
{
    $STH = $DBH->prepare('SELECT * FROM users WHERE email = ?');
    $STH->execute([0 => $email]);
    $data = [];

    while ($row = $STH->fetch()) {
        $data[] = $row;
    }
    return $data;
}

/**
 * Получает всех пользователей из БД в виде ассоциативного массива.
 *
 * @param pdo $DBH
 *
 * @return array
 */
function db_getAllUsers(pdo $DBH) : array
{
    $STH = $DBH->prepare('SELECT * FROM users');
    $STH->execute();
    $data = $STH->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}


/**
 * Получает все заказы из БД в виде ассоциативного массива.
 *
 * @param pdo $DBH
 *
 * @return array
 */
function db_getAllOrders(pdo $DBH) : array
{
    $STH = $DBH->prepare('SELECT * FROM orders');
    $STH->execute();
    $data = $STH->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

/**
 * Собирает из переданных данных строку с телом письма.
 *
 * @param string $order_address
 * @param int $order_id
 * @param string $order_num
 *
 * @return string
 */
function composeLetter(string $order_address, int $order_id, string $order_num) : string
{
    $br = PHP_EOL;
    return <<<EOT
        Заказ № $order_id $br
        Ваш заказ будет доставлен по адресу: $order_address $br
        Содержимое заказа: DarkBeefBurger за 500 рублей, 1 шт $br
        Спасибо - это ваш $order_num заказ
EOT;
}

/**
 * Формирует из post запроса массив данных пользователя для последующей вставки в БД
 *
 * @return array
 */
function formUserFromPost() : array
{
    $user = [];

    $user[] = $_POST['name'];
    $user[] = $_POST['email'];
    $user[] = $_POST['phone'];

    return $user;
}

/**
 * Формирует из post запроса массив данных заказа для последующей вставки в БД.
 *
 * @param int $user_id
 * @return array
 */
function formOrderFromPost(int $user_id) : array
{
    $order = [];

    $order[] = $user_id;
    $order[] = $_POST['street'] . ', ' . $_POST['home'] . ' - ' . $_POST['part'] . ', ' . $_POST['appt'];
    $order[] = $_POST['comment'];
    $order[] = $_POST['payment'];
    $order[] = $_POST['callback'];

    return $order;
}

/**
 * Получает из БД заказов число рядов, относящихся к указанному пользователю.
 *
 * @param pdo $DBH
 * @param $user_id
 *
 * @return int
 */
function db_getOrdersCount(pdo $DBH, $user_id) : int
{
    $STH = $DBH->prepare('SELECT count(id) FROM orders WHERE user_id = ?');
    $STH->execute([0 => $user_id]);
    $num_rows = $STH->fetchColumn();
    return $num_rows;
}

/**
 * Собирает соответствующую переданному число строку с числом заказов для использования в письме.
 *
 * @param pdo $DBH
 * @param $user_id
 *
 * @return string
 */
function composeOrdersCountString(pdo $DBH, $user_id) : string
{
    $num_rows = db_getOrdersCount($DBH, $user_id);
    if ($num_rows < 2) {
        $str = 'первый';
    } else {
        $str = (string) $num_rows;
    }
    return $str;
}
