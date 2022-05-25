<?php

function ValidarRegistro($Usuario, $FechaRegistro, $connMysql)
{

    $SQL  = "SELECT ID,TiempoInactivo,TiempoActivo FROM tbl_prod_historico WHERE Usuario='$Usuario' AND FechaRegistro='$FechaRegistro' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        $data['ID']             = $row['ID'];
        $data['TiempoInactivo'] = $row['TiempoInactivo'];
        $data['TiempoActivo']   = $row['TiempoActivo'];

    } else {
        $data['TiempoInactivo'] = 0;
        $data['TiempoActivo']   = 0;
        $data['ID']             = false;
    }

    return $data;
}


function KeyWords($connMysql)
{
    $SQL  = "SELECT keyword FROM tbl_prod_software_keywords";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $results   = $stmt->fetchAll();
    $dataArray = array();
    foreach ($results as $row) {
        $dataArray[] = $row['keyword'];
    }
    return implode('|', $dataArray);

}

function NombreAplicativo($connMysql, $ValueSearch, $Type)
{
    if ($Type == 1) {
        $SQL = "SELECT
    tbl_prod_software_keywords.keyword,
    tbl_prod_software.Nombre,
    tbl_prod_software_keywords.IdSoftware,
    tbl_prod_software.ID
FROM
    tbl_prod_software_keywords
    INNER JOIN tbl_prod_software ON tbl_prod_software_keywords.IdSoftware = tbl_prod_software.ID
WHERE
    tbl_prod_software_keywords.keyword = '$ValueSearch'";
    } else {
        $SQL = "SELECT Nombre FROM tbl_prod_software where Ejecutable  like '$ValueSearch'";
    }

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    $row      = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($Cantidad > 0) {
        return $row['Nombre'];
    } else {
        return 0;
    }

}

function ValidarRegla($connMysql, $Usuario, $Aplicativo)
{
    $SQL = "SELECT * FROM tbl_prod_reglas_usuarios
    INNER JOIN tbl_prod_reglas
    ON tbl_prod_reglas_usuarios.IdRegla = tbl_prod_reglas.ID
    WHERE tbl_prod_reglas_usuarios.UsuariodeRed = '$Usuario'
    AND tbl_prod_reglas.Software = '$Aplicativo'";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    $row      = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($Cantidad > 0) {
        return $row;
    } else {
        $data           = array();
        $data['Tiempo'] = 60;
        return $data;
    }

}

function LastIDRecord($connMysql, $Usuario)
{
    $SQL  = "SELECT ID,Aplicativo,TiempoAcumulado,Estado FROM tbl_prod_general WHERE ID = (SELECT max(ID) FROM tbl_prod_general) AND Usuario = '$Usuario';";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    $row      = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($Cantidad > 0) {
         //print_r($row) ;
        return $row;

    } else {
        $data           = array();
        $data['ID'] = false;
        return $data;
    }

}


function DeleteRegistroAcumulado($connMysql, $ID,$table)
{
    $SQL  = "DELETE FROM $table WHERE ID = '$ID'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    
}



function LastIDRecordUsuarios($connMysql, $Usuario)
{
    $SQL  = "SELECT ID,Tiempo,Estado FROM tbl_prod_consolidado WHERE ID = (SELECT max(ID) FROM tbl_prod_consolidado) AND Usuario = '$Usuario';";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $Cantidad = $stmt->rowCount();
    $row      = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($Cantidad > 0) {
         //print_r($row) ;
        return $row;

    } else {
        $data           = array();
        $data['ID'] = false;
        return $data;
    }

}

