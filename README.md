# php-ls-project-1

*php/form.php* собирает данные о пользователе и заказа из Post запроса в массивы, проверяет есть ли пользователь в БД и при отсутствии добавляет пользователя, добавляет заказ, формирует и отправляет письмо с помощью встроенной функции mail, выдаёт подтверждение заказа и отправки письма, либо сообщения об ошибках.

*php/connect.php* соединяет с БД

*php/functions.php* содержит вынесенный функционал

*admin.php* выводит всех пользователей и все заказы

*schema.sql* содержит структуру таблиц заказов и пользователей

*js/form.js* передаёт отправленную форму с помощью xhr/formdata на сервер и принимает ответы в модальное окно

