<?php

class Config
{
    // Настроек от проекта в личном кабинете free-kassa.ru
    const MERCHANT_ID = '1';
    const SECRET_KEY_1 = '1';
    const SECRET_KEY_2 = '1';
    
    // Стоимость товара в руб.
    const ITEM_PRICE = 1;

    // Таблица начисления товара, например `users`
    const TABLE_ACCOUNT = 'accounts';
    // Название поля из таблицы начисления товара по которому производится поиск аккаунта/счета, например `email`
    const TABLE_ACCOUNT_NAME = 'name';
    // Название поля из таблицы начисления товара которое будет увеличено на колличево оплаченого товара, например `sum`, `donate`
    const TABLE_ACCOUNT_DONATE= 'money';

    // Параметры соединения с бд
    // Хост
    const DB_HOST = '1';
    // Имя пользователя
    const DB_USER = '1';
    // Пароль
    const DB_PASS = '1';
    // Назывние базы
    const DB_NAME = '1';
}