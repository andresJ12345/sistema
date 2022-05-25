<?php

function InsertDataMasiva($DataJson)
{
    $FunctionsMySQL = new FunctionsMySQL();
    $connMysql      = connMysql();
    $DecodeDataJson = json_decode($DataJson, true);

    function replace($match)
    {
        $key = trim($match[1]);
        $val = trim($match[2]);

        if ($val[0] == '"') {
            $val = '"' . addslashes(substr($val, 1, -1)) . '"';
        } else if ($val[0] == "'") {
            $val = "'" . addslashes(substr($val, 1, -1)) . "'";
        }

        return $key . ": " . $val;
    }
    $preg = preg_replace_callback("#([^{:]*):([^,}]*)#i", 'replace', $DataJson);

    $json_array = json_decode($preg, true);

    $CantidadRegistros = count($json_array);

    foreach ($json_array as $row) {
        $TiempoActivo   = 0;
        $TiempoInactivo = 0;
        $FechaRegistro  = $row['FechaRegistro'];
        $Usuario        = strtolower(str_replace(' ', '', $row['Usuario']));
        $Software       = utf8_decode(base64_decode(ltrim(rtrim($row['Software']))));
        $SoftwareTitulo = utf8_decode(base64_decode(ltrim(rtrim($row['SoftwareTitulo']))));
        $DataLast       = ValidarLastRegistro($Usuario, $connMysql);
        $IdTittle       = md5($SoftwareTitulo);
        if ($Software == 'INACTIVO') {
            if ($row['Tiempo'] < 60) {
                $Estado         = 1;
                $TiempoActivo   = $row['Tiempo'];
                $Software       = $DataLast['Software'];
                $SoftwareTitulo = $DataLast['SoftwareTitulo'];
                $IdTittle       = md5($SoftwareTitulo);
            } else {
                $Estado         = 0;
                $TiempoInactivo = $row['Tiempo'];
            }
        } else {
            if ($row['Estado'] == 0) {

                if ($row['Tiempo'] < 60) {
                    $Estado       = 1;
                    $TiempoActivo = $row['Tiempo'];
                } else {
                    $Estado         = 0;
                    $TiempoInactivo = $row['Tiempo'];
                }
            } else {
                $Estado       = 1;
                $TiempoActivo = $row['Tiempo'];
            }
        }
        $arrayDataGeneral = array(
            'Usuario'        => $Usuario,
            'NombrePC'       => $row['NombrePC'],
            'Software'       => $Software,
            'SoftwareTitulo' => $SoftwareTitulo,
            'Estado'         => $Estado,
            'Tiempo'         => $row['Tiempo'],
            'FechaRegistro'  => $FechaRegistro,
            'HoraRegistro'   => $row['HoraRegistro'],
        );

        $FunctionsMySQL->Insert($arrayDataGeneral, 'tbl_productividad_general', $connMysql);

####Procedmos a consolidar Datos ##
        $DataConsolidado = ValidarLastGeneral($row['Usuario'], $FechaRegistro, $connMysql);
        if ($Estado != $DataConsolidado['Estado'] && $row['Software'] != $DataConsolidado['Software']) {

            $FunctionsMySQL->Insert($arrayDataGeneral, 'tbl_productividad_consolidado', $connMysql);

        } elseif ($DataConsolidado['ID'] > 0 && $Estado == $DataConsolidado['Estado'] && $row['Software'] == $DataConsolidado['Software']) {
            unset($arrayDataGeneral['FechaRegistro']);
            unset($arrayDataGeneral['HoraRegistro']);

            $arrayDataGeneral['ID']               = $DataConsolidado['ID'];
            $arrayDataGeneral['HoraRegistroFin']  = $row['HoraRegistro'];
            $arrayDataGeneral['FechaRegistroFin'] = $FechaRegistro;
            $FunctionsMySQL->Update($arrayDataGeneral, 'tbl_productividad_consolidado', $connMysql);
        } else {
            $FunctionsMySQL->Insert($arrayDataGeneral, 'tbl_productividad_consolidado', $connMysql);
        }

####Procedmos a Sumar o registrar Historico

        $DataHistorico      = ValidarRegistro($row['Usuario'], $FechaRegistro, $connMysql);
        $arrayDataHistorico = array(
            'Usuario'        => $row['Usuario'],
            'TiempoActivo'   => $DataHistorico['TiempoActivo'] + $TiempoActivo,
            'TiempoInactivo' => $DataHistorico['TiempoInactivo'] + $TiempoInactivo,
            'FechaRegistro'  => $FechaRegistro,
            'HoraRegistro'   => $row['HoraRegistro'],
        );
        if ($DataHistorico['ID'] == false) {
            if ($Estado == 1) {
                $arrayDataHistorico['HoraPrimerActividad'] = $row['HoraRegistro'];
            }
            $arrayDataHistorico['NombrePC']            = $row['NombrePC'];
            $arrayDataHistorico['HoraUltimaActividad'] = $row['HoraRegistro'];
            $FunctionsMySQL->Insert($arrayDataHistorico, 'tbl_productividad_historico', $connMysql);
        } else {
            if ($Estado == 1) {
                $arrayDataHistorico['HoraUltimaActividad'] = $row['HoraRegistro'];
            }
            $arrayDataHistorico['ID'] = $DataHistorico['ID'];
            $FunctionsMySQL->Update($arrayDataHistorico, 'tbl_productividad_historico', $connMysql);
        }
####Procedmos a Sumar o registrar Historico POR APLICACIONES
        $DataSoftware      = ValidarRegistroSoftware($Usuario, $Software, $IdTittle, $FechaRegistro, $connMysql);
        $DataSoftwareArray = array(
            'Usuario'        => $Usuario,
            'TiempoActivo'   => $DataSoftware['TiempoActivo'] + $TiempoActivo,
            'TiempoInactivo' => $DataSoftware['TiempoInactivo'] + $TiempoInactivo,
            'FechaRegistro'  => $FechaRegistro,
            'HoraRegistro'   => $row['HoraRegistro'],
            'Software'       => $Software,
            'SoftwareTitulo' => $SoftwareTitulo,
            'IdTittle'       => $IdTittle,
        );
        if ($DataSoftware['ID'] == false) {

            $DataSoftwareArray['HoraPrimerActividad'] = $row['HoraRegistro'];
            $DataSoftwareArray['HoraUltimaActividad'] = $row['HoraRegistro'];
            $FunctionsMySQL->Insert($DataSoftwareArray, 'tbl_productividad_time_software', $connMysql);
        } else {
            if ($Estado == 1) {
                $DataSoftwareArray['HoraUltimaActividad'] = $row['HoraRegistro'];
            }
            $DataSoftwareArray['ID'] = $DataSoftware['ID'];
            $FunctionsMySQL->Update($DataSoftwareArray, 'tbl_productividad_time_software', $connMysql);
        }

    }
    return $CantidadRegistros;
}

function ValidarRegistro($Usuario, $FechaRegistro, $connMysql)
{

    $SQL  = "SELECT ID,TiempoInactivo,TiempoActivo FROM tbl_productividad_historico WHERE Usuario='$Usuario' AND FechaRegistro='$FechaRegistro' ";
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

function ValidarRegistroSoftware($Usuario, $Software, $IdTittle, $FechaRegistro, $connMysql)
{

    $SQL  = "SELECT ID,TiempoInactivo,TiempoActivo FROM tbl_productividad_time_software WHERE Usuario='$Usuario' AND Software ='$Software' AND IdTittle='$IdTittle' AND FechaRegistro='$FechaRegistro' ORDER BY ID desc";
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

function ValidarLastGeneral($Usuario, $FechaRegistro, $connMysql)
{

    $SQL  = "SELECT * FROM tbl_productividad_consolidado WHERE  Usuario='$Usuario' AND FechaRegistro='$FechaRegistro' ORDER BY ID DESC LIMIT 1  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $data['ID']             = $row['ID'];
        $data['Estado']         = $row['Estado'];
        $data['Software']       = $row['Software'];
        $data['SoftwareTitulo'] = $row['SoftwareTitulo'];

    } else {
        $data['ID']             = 0;
        $data['Estado']         = 0;
        $data['Software']       = 0;
        $data['SoftwareTitulo'] = 0;

    }

    return $data;
}

function ValidarLastRegistro($Usuario, $connMysql)
{

    $SQL  = "SELECT * FROM tbl_productividad_general WHERE  Usuario='$Usuario' ORDER BY ID DESC LIMIT 1  ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $data       = array();
    $FechasHtml = '';
    $row        = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        $data['Software']       = $row['Software'];
        $data['SoftwareTitulo'] = $row['SoftwareTitulo'];

    } else {

        $data['Software']       = 'INACTIVO';
        $data['SoftwareTitulo'] = 'INACTIVO';

    }

    return $data;
}
