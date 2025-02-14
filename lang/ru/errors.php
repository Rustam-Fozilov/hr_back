<?php

return [

    'app_exists' => 'У клиента сегодня есть заявка!',
    'auth_failed' => 'Номер пользователя или пароль неверны!',
    'auth_forbidden' => 'Вы не можете использовать систему!',
    'not_found' => ':name не найдено!',
    'tin' => 'Неверный ИНН!',
    'pinfl' => 'PINFL неправильный!',
    'pinfl_birth_date' => 'Введенное значение дня рождения не соответствует PINFL!',
    'unknown' => 'Неизвестная ошибка!',
    'file_upload' => 'Ошибка загрузки файла!',
    'file_delete' => 'Ошибка удаления файла!',
    'file_move' => 'Ошибка перемещения файла!',
    'file_confirmed' => 'Файл уже проверен!',
    'unauthorized' => 'Войдите, чтобы использовать систему!',
    'role_not_found' => 'Роль ":role" не найдена!',
    'forbidden' => 'Нет прав доступа!',
    'forbidden_role' => 'У вас нет разрешения на ":role"!',

    'client_already_registered' => 'Клиент уже зарегистрирован!',
    'client_login_with_password' => 'Зарегистрируйтесь с паролем!',
    'client_code_expired' => 'Срок действия пароля истек!',
    'client_blocked' => 'Слишком много попыток! Вы заблокированы до :time!',
    'client_not_active' => 'Клиент не проверен!',
    'client_already_confirmed' => 'Клиент уже проверен!',

    'delete_in_use' => 'Эта информация не может быть удалена, потому что информация используется!',

    'app' => [
        'status' => 'Ошибка статуса!',
        'files' => 'Изображения клиентов неполные!',
        'registration_address' => "Данные прописки клиента введено не полностью!",
        'partner_queue' => "Очередь на отправку заявки партнеру не существует или отменена!",
        'client_limit' => 'Клиенту не хватает лимита!',
        'loan_amount' => 'Сумма кредита не подходит!',
        'bind' => 'Идентификатор привязки ":bind" не существует!',
        'call_later' => 'Ждите ответа скоринга',
        'partner_rejected' => 'ОТКАЗАНО, нет предложений',
        'product_not_marked' => 'Товар не маркируется!'
    ],

    'file' => [
        'face' => 'Загрузите фотографию лица клиента !',
        'passport' => 'Загрузите фотографию паспорта клиента !',
        'passport_selfie' => 'Загрузите фото паспорта клиента ! (Selfie)',
        'passport_address' => 'Загрузите фотографию адреса паспорта клиента !',
        'client_product' => 'Загрузите фотографию продукта клиента !',
        'client_sign' => 'Загрузите изображение подписи клиента !',
        'product_contract' => 'Загрузите изображение продукта клиента ! '
    ]

];
