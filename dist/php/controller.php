<?php

require_once "config/definidas.php";
require_once "config/conndb.php";
require_once "classes/class_MySQL.php";
require_once "func_Usuario/func_Usuario.php";


if (isset($_POST['PostMethod'])) {
    $PostMethod = $_POST['PostMethod'];
    $connMysql = connMysql();
    switch ($PostMethod) {

        case 'UsuariosTable':
            echo UsuariosTable($connMysql);
            break;
        case 'AccionesUsuario':
            echo AccionesUsuario($connMysql);
            break;
        case 'EliminarUSuario':
            echo EliminarUSuario($connMysql);
            break;
        case 'DetalleUSuario':
            echo DetalleUSuario($connMysql);
            break;

        default:
            return 500;
            break;
    }
} else {
    return 500;
}
