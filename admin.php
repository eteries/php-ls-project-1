<?php
require_once('php/functions.php');
require_once('php/connect.php');

$users = db_getAllUsers($DBH);
$orders = db_getAllOrders($DBH);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ
    </title>
    <link rel="stylesheet" href="css/vendors.min.css">
    <link rel="stylesheet" href="css/main.min.css">
    <style>
      body {
        color: white;
        background: black;
      }
      h1 {
        padding: 20px 0;
        border-bottom: 1px solid white;
        border-top: 1px solid white;
        margin: 20px 0;
      }
      table + h2 {
        margin-top: 20px;
      }

      table.output td, table.output th {
        border: 1px dotted white;
        padding: 4px 8px;
      }

      table.layout td:first-child {
        padding-right: 30px;
        vertical-align: top;
      }
      table.layout td:last-child {
        padding-left: 30px;
        vertical-align: top;
      }

      span.change:before {
        content: 'Нужна сдача';
      }
      span.card:before {
        content: 'Оплата картой';
      }
      span.call:before {
        content: 'Звонить';
      }
      span.call.on:before {
        content: 'Не звонить';
      }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="maincontent">
        <section class="">
            <div class="container">
                <h1>Админ-панель</h1>
                    <h2>Пользователи:</h2>
                    <?php if (empty($users)) : ?>
                      <p>Пользователей не найдено</p>
                    <?php else : ?>
                      <table class="output">
                        <tr>
                          <th>ID</th>
                          <th>Имя</th>
                          <th>Email</th>
                          <th>Телефон</th>
                        </tr>
                        <?php foreach ($users as $user) : ?>
                          <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['phone'] ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
                    <h2>Заказы:</h2>
                    <?php if (empty($orders)) : ?>
                      <p>Заказов не найдено</p>
                    <?php else : ?>
                    <table class="output">
                      <tr>
                        <th>ID</th>
                        <th>Адрес</th>
                        <th>Комментарий</th>
                        <th>Оплата</th>
                        <th>Звонить?</th>
                        <th>ID пользователя</th>
                      </tr>
                        <?php foreach ($orders as $order) : ?>
                          <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['address'] ?></td>
                            <td><?= $order['comment'] ?></td>
                            <td><span class="<?= $order['payment']  ?>"</td>
                            <td><span class="call <?= $order['callback'] ?>"</td>
                            <td><?= $order['user_id'] ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
            </div>
        </section>
    </div>
</div>
</body>
</html>