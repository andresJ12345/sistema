<?php

function connMysql()
{

    switch (EstadoProyecto) {
        case 1:
            $username          = 'root';
            $password          = '';
            $db                = 'estratego_crm';
            return $connection = new PDO('mysql:host=localhost;dbname=' . $db, $username, $password, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'utf8mb4\''));
            break;
        case 2:
            $username          = 'root';
            $password          = '';
            $db                = 'estratego_crm';
            return $connection = new PDO('mysql:host=localhost;dbname=' . $db, $username, $password, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'utf8mb4\''));
            break;
        case 3:
            $username          = 'root';
            $password          = '';
            $db                = 'estratego_crm';
            return $connection = new PDO('mysql:host=localhost;dbname=' . $db, $username, $password, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'utf8mb4\''));
            break;
    }
}
