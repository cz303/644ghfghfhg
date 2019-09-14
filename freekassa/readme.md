## Требования
1. MySQL сервер
2. PHP версии 5.* или выше
3. Установленное PHP расширение mysqli (для работы с бд mysql)

## 1. Создайте таблицу в базе данных, используя следующий запрос
```sql
CREATE TABLE IF NOT EXISTS `freekassa_payments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `freekassaId` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `sum` float NOT NULL,
  `itemsCount` int(11) NOT NULL DEFAULT '1',
  `dateCreate` datetime NOT NULL,
  `dateComplete` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
```
В эту таблицу будет записываться информация о транзакциях


## 2. Разместите файлы скрипта в любой директории веб сервера
На скриншоте используется корневая директория домена, но это не обязательно.
![image](https://cloud.githubusercontent.com/assets/9200174/21964858/86e03822-db5c-11e6-9c64-bb6641545b94.png)

## 3. Настройте скрипт через config.php
Укажите в нем данные для подключения к созданной базе данных, стоимость одной единицы товара (предмета) и секретный ключ, который можно найти в настройках проекта в личном кабинете freekassa.ru

## 4. В личном кабинете укажите URL оповещения:
Если вы загружали файлы модуля в корень, то путь - http://www.YOURSITE.ru/index.php
Если файлы не в корне, то укажите правильный путь к файлу /index.php

## 5. Пример формы для оплаты
<form action="http://www.YOURSITE.ru/index.php">
    <input name="action" value="fk_go" class="main_input" type="hidden">
    <input name="account" placeholder="Ник аккаунта" class="main_input" type="text"><br>
    <input name="sum" placeholder="Сумма пополнения" class="main_input" type="text"><br>
    <button class="dl_btn">Оплатить</button>
</form>

Ссылку для формы оплаты использовать ту же самую, что и для обработчика из пункта №4