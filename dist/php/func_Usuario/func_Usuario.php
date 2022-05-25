<?php

function UsuariosTable($connMysql)
{

    $SQL = "SELECT * from usuarios";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $result        = $stmt->fetchAll();
    $data          = array();

    // print_r($result);

    $BtnBorrar = '';
    $BtnEditar = '';
    foreach ($result as $row) {

        $BtnEditar    = '<a  data-id="' . $row['id'] . '" href="javascript:void(0)"  class="btn btn-outline-info mr-15  BtnEditarUSuario " title="Editar Usuario"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> Editar </a>';
        $BtnBorrar = '<a  data-id="' . $row['id'] . '" href="javascript:void(0)"  class="btn btn-outline-danger mr-15 BtnEliminarUSuario " title="Eliminar Usuario"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Borrar </a>';


        $anidado  = array();
        $anidado[] = $row['nombre'];
        $anidado[] = $row['Usuario'];
        $anidado[] = $row['fecha'];
        $anidado[] = "<h5>" . $BtnEditar . "  " . $BtnBorrar . "<h5>";

        $data[] = $anidado;
    }
    $json_data = array(
        "draw"            => intval(1),
        "recordsTotal"    => intval($CantidadTotal),
        "recordsFiltered" => intval($CantidadTotal),
        "data"            => $data,
    );
    return json_encode($json_data);
}
function AccionesUsuario($connMysql)
{
    $FunctionsMySQL = new FunctionsMySQL();

    unset($_POST['PostMethod']);
    foreach ($_POST as $camposInsert => $valueCampo) {
        if (strlen($valueCampo) > 0) {
            $ArrayValidation[$camposInsert] = $valueCampo;
        } else {
            return 3;
        }
    }

    $arraySQLDB = array(
        'nombre' => $ArrayValidation['nombre'],
        'Usuario' => $ArrayValidation['usuario'],
        'fecha' => $ArrayValidation['fecha']
    );
    if ($ArrayValidation['idUser'] == 'NA') {
        $FunctionsMySQL->Insert($arraySQLDB, 'usuarios', $connMysql);
        return 1;
    } else {
        $arraySQLDB['id'] = $ArrayValidation['idUser'];
        $FunctionsMySQL->Update($arraySQLDB, 'usuarios', $connMysql);
        return 2;
    }
}


function EliminarUSuario($connMysql)
{
    $idUser = $_POST['idUser'];
    $SQL  = "DELETE from usuarios WHERE id='$idUser'";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    return 1;
}
function DetalleUSuario($connMysql)
{
    $idUser = $_POST['idUser'];
    $SQL  = "SELECT * from usuarios WHERE id='$idUser'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return json_encode(array('nombre'=>$row['nombre'],'usuario'=>$row['Usuario'],'fecha'=>$row['fecha']));
}
// function CliCot($Asesor, $connMysql)
// {
//     $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$Asesor'";

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }

// function GetCliCotizar($connMysql, $Asesor, $FechaActual)
// {
//     $mes_start = strtotime('first day of this month', strtotime($FechaActual));
//     $FechaInicial = date('Y-m-d', $mes_start);
//     $mes_end = strtotime('last day of this month', strtotime($FechaActual));
//     $FechaFinal =  date('Y-m-d', $mes_end);

//     // $SQL = "SELECT * from est_gestiones WHERE creado_por = '$Asesor' AND fecha_gestion BETWEEN '$FechaActual' AND '$FechaFinal' AND (estado = 'Cotizado' OR estado = 'NuevoCotizado')";
//     $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$Asesor' AND DATE(fecha_gestion) = DATE('$FechaActual') AND (estado = 'Cotizado' OR estado = 'NuevoCotizado')";

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }

function GetRegistrosAsignados($Asesor, $FechaInicial, $FechaFin, $TablaTipo, $connMysql)
{
    // print_r($TablaTipo);
    // $mes_start = strtotime('first day of this month', strtotime($FechaInicial));
    // $FechaInicial = date('Y-m-d', $mes_start);
    // $mes_end = strtotime('last day of this month', strtotime($FechaFin));
    // $FechaFin =  date('Y-m-d', $mes_end);
    $SQL  = "SELECT * from est_gestiones WHERE tipo_cliente = '$TablaTipo' AND asignadoA = '$Asesor' AND estado_Asignacion = 'Asignado' AND fecha_gestion BETWEEN '$FechaInicial' AND '$FechaFin'";

    // $SQL  = "SELECT * from est_gestiones WHERE asignadoA = '$Asesor' AND DATE(fecha_gestion) = DATE('$FechaActual')";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $CantidadTotal;
}

function Efectividad($connMysql, $Asesor, $FechaInicial, $FechaFin, $TablaTipo)
{

    $Asignados = GetRegistrosAsignados($Asesor, $FechaInicial, $FechaFin, $TablaTipo, $connMysql);
    $Cierres = Cierres($connMysql, $Asesor, $FechaInicial, $FechaFin, $TablaTipo);
    // var_dump($Asignados);
    // var_dump($Cierres);
    if ($Asignados > 0 && $Cierres > 0) {
        $TotalEfectividad = $Cierres / $Asignados;
        $Resultado = floatval($TotalEfectividad) * 100;
        // print_r($Resultado);
        return number_format($Resultado, 0, '.', '');
    } else {
        return 0;
    }
    // var_dump($TotalEfectividad);
}

function GetCliCotizarMess($connMysql, $Asesor, $FechaInicial, $TablaTipo, $FechaFin)
{
    // $mes_start = strtotime('first day of this month', strtotime($FechaInicial));
    // $FechaInicial = date('Y-m-d', $mes_start);
    // $mes_end = strtotime('last day of this month', strtotime($FechaFin));
    // $FechaFin =  date('Y-m-d', $mes_end);


    $SQL  = "SELECT * from est_gestiones WHERE tipo_cliente = '$TablaTipo' AND asignadoA = '$Asesor' AND fecha_gestion BETWEEN '$FechaInicial' AND '$FechaFin' AND (estado = 'Cotizado' OR estado = 'NuevoCotizado')";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($CantidadTotal);
    return $CantidadTotal;
}

function Cierres($connMysql, $Asesor, $FechaInicial, $FechaFin, $TablaTipo)
{
    // $mes_start = strtotime('first day of this month', strtotime($FechaInicial));
    // $FechaInicial = date('Y-m-d', $mes_start);
    // $mes_end = strtotime('last day of this month', strtotime($FechaFin));
    // $FechaFin =  date('Y-m-d', $mes_end);
    // print_r($FechaFin);


    $SQL  = "SELECT * from est_gestiones WHERE tipo_cliente = '$TablaTipo' AND asignadoA = '$Asesor' AND fecha_gestion BETWEEN '$FechaInicial' AND '$FechaFin' AND estado = 'Venta'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($CantidadTotal);
    return $CantidadTotal;
}

// function filtrardia($connMysql)
// {
//     // $Asesor = $_SESSION['UsuarioLogueado'];
//     $dia = $_POST['dia'];
//     $mes = $_POST['mes'];
//     $ano = $_POST['ano'];
//     $Fech = $ano . '-' . $mes . '-' . $dia;
//     // var_dump($Fech);
//     // $FechaActual      = date("d");
//     $SQL = "SELECT * from est_gestiones WHERE DATE_FORMAT(created,'%y-%m-%d') = DATE('$Fech') AND estado = 'Cotizado'";

//     // $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$Asesor' AND DATE(created) = DATE('$FechaActual') AND estado = 'Cotizado'";

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     // var_dump($CantidadTotal);
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }



















// function GetProspectos($connMysql)
// {
//     $data          = array();

//     $sesion = $_SESSION['UsuarioLogueado'];
//     $FechaActual      = date("Y-m-d");
//     // var_dump($FechaActual);
//     $CliCot = GetCliCotizar($connMysql, $FechaActual);
//     $SinCliCot = GetSinCliCotizar($connMysql, $FechaActual);

//     if ($sesion == 'admin') {
//         $SQL  = "SELECT * from estr_clientes WHERE DATE(created) = DATE('$FechaActual')";
//     } else {
//         $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$sesion' AND DATE(created) = DATE('$FechaActual')";
//     }

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);

//     $data['Prospecto'] = $CantidadTotal;
//     $data['CliCot'] = $CliCot;
//     $data['SinCliCot'] = $SinCliCot;

//     return json_encode($data);
// }

// function GetCliCotizar($connMysql, $FechaActual)
// {
//     $sesion = $_SESSION['UsuarioLogueado'];
//     // var_dump($sesion);

//     if ($sesion == 'admin') {
//         $SQL  = "SELECT * from est_gestiones WHERE DATE(created) = DATE('$FechaActual') AND estado = 'Cotizado'";
//     } else {
//         $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$sesion' AND DATE(created) = DATE('$FechaActual') AND estado = 'Cotizado'";
//     }

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }

// function GetSinCliCotizar($connMysql, $FechaActual)
// {
//     $sesion = $_SESSION['UsuarioLogueado'];
//     // var_dump($sesion);

//     if ($sesion == 'admin') {
//         $SQL  = "SELECT * from est_gestiones WHERE DATE(created) = DATE('$FechaActual') AND estado = 'SinGestion'";
//     } else {
//         $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$sesion' AND DATE(created) = DATE('$FechaActual') AND estado = 'SinGestion'";
//     }

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }
// /* MES */

// function GetProspectosMes($connMysql)
// {
//     $data          = array();

//     $sesion = $_SESSION['UsuarioLogueado'];
//     $FechaActual      = date("Y-m");
//     // var_dump($FechaActual);
//     $CliCot = GetCliCotizarMes($connMysql, $FechaActual);

//     if ($sesion == 'admin') {
//         $SQL  = "SELECT * from estr_clientes WHERE DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual')";
//     } else {
//         $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$sesion' AND DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual')";
//     }

//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);

//     $data['Prospecto'] = $CantidadTotal;
//     $data['CliCot'] = $CliCot;

//     return json_encode($data);
// }

// function GetCliCotizarMes($connMysql, $FechaActual)
// {
//     $sesion = $_SESSION['UsuarioLogueado'];
//     // var_dump($sesion);

//     if ($sesion == 'admin') {
//         $SQL  = "SELECT * from est_gestiones WHERE DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual') AND estado = 'Cotizado'";
//     } else {
//         $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$sesion' AND DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual') AND estado = 'Cotizado'";
//     }
//     $stmt = $connMysql->prepare($SQL);
//     $stmt->execute();
//     $CantidadTotal = $stmt->rowCount();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $CantidadTotal;
// }




function ConfiguracionesTableProspectadoresInicio($connMysql)
{

    $fechaInicio = isset($_POST['fechaInicioProspectadores']) ? $_POST['fechaInicioProspectadores'] : date("Y-m-d");
    $fechaFin = isset($_POST['fechaFinProspectadores']) ? $_POST['fechaFinProspectadores'] : date("Y-m-d");
    $Fech = $fechaInicio;
    $FechFin = $fechaFin;
    // $TablaTipo = isset($_POST['TablaTipo']) ? $_POST['TablaTipo'] : 'Prospectacion' ;
    // var_dump($fechaInicio);
    // var_dump($fechaFin);
    $asignado_a = $_SESSION['UsuarioLogueado'];

    if ($asignado_a == 'admin') {
        $SQL  = " SELECT * FROM est_usuarios WHERE perfil = '3'";
    } else {
        $SQL  = "SELECT * FROM est_usuarios";
    }


    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $result        = $stmt->fetchAll();
    $data          = array();

    // print_r($result);

    $BtnBorrar = '';
    $BtnEditar = '';
    foreach ($result as $row) {


        $anidado  = array();
        $anidado[] = $row['user'];
        $anidado[] = ProspectosProspectadores($row['user'], $Fech, $FechFin, $connMysql);

        $data[] = $anidado;
    }
    $json_data = array(
        "draw"            => intval(1),
        "recordsTotal"    => intval($CantidadTotal),
        "recordsFiltered" => intval($CantidadTotal),
        "data"            => $data,
    );
    return json_encode($json_data);
}

function ProspectosProspectadores($Asesor, $FechaInicial, $FechaFin, $connMysql)
{
    // $mes_start = strtotime('first day of this month', strtotime($FechaInicial));
    // $FechaInicial = date('Y-m-d', $mes_start);
    // $mes_end = strtotime('last day of this month', strtotime($FechaFin));
    // $FechaFin =  date('Y-m-d', $mes_end);

    $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$Asesor' AND created BETWEEN '$FechaInicial' AND '$FechaFin'";

    // $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$Asesor'";

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $CantidadTotal;
}































function GetProspectos($connMysql)
{
    $data          = array();

    $sesion = $_SESSION['UsuarioLogueado'];
    $FechaActual      = date("Y-m-d");
    // var_dump($FechaActual);
    $CliCot = GetCliCotizar($connMysql, $FechaActual);
    $SinCliCot = GetSinCliCotizar($connMysql, $FechaActual);

    if ($sesion == 'admin') {
        $SQL  = "SELECT * from estr_clientes WHERE DATE(created) = DATE('$FechaActual')";
    } else {
        $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$sesion' AND DATE(created) = DATE('$FechaActual')";
    }

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $data['Prospecto'] = $CantidadTotal;
    $data['CliCot'] = $CliCot;
    $data['SinCliCot'] = $SinCliCot;

    return json_encode($data);
}

function GetCliCotizar($connMysql, $FechaActual)
{
    $sesion = $_SESSION['UsuarioLogueado'];
    // var_dump($sesion);

    if ($sesion == 'admin') {
        $SQL  = "SELECT * from est_gestiones WHERE DATE(created) = DATE('$FechaActual') AND estado = 'Cotizado'";
    } else {
        $SQL  = "SELECT * from est_gestiones WHERE asignadoA = '$sesion' AND DATE(created) = DATE('$FechaActual') AND estado = 'Cotizado'";
    }

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $CantidadTotal;
}

function GetSinCliCotizar($connMysql, $FechaActual)
{
    $sesion = $_SESSION['UsuarioLogueado'];
    // var_dump($sesion);

    if ($sesion == 'admin') {
        $SQL  = "SELECT * from est_gestiones WHERE DATE(created) = DATE('$FechaActual') AND estado = 'SinGestion'";
    } else {
        $SQL  = "SELECT * from est_gestiones WHERE creado_por = '$sesion' AND DATE(created) = DATE('$FechaActual') AND estado = 'SinGestion'";
    }

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $CantidadTotal;
}
/* MES */

function GetProspectosMes($connMysql)
{
    $data          = array();

    $sesion = $_SESSION['UsuarioLogueado'];
    $FechaActual      = date("Y-m");
    // var_dump($FechaActual);
    $CliCot = GetCliCotizarMes($connMysql, $FechaActual);

    if ($sesion == 'admin') {
        $SQL  = "SELECT * from estr_clientes WHERE DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual')";
    } else {
        $SQL  = "SELECT * from estr_clientes WHERE ingresado_por = '$sesion' AND DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual')";
    }

    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $data['Prospecto'] = $CantidadTotal;
    $data['CliCot'] = $CliCot;

    return json_encode($data);
}

function GetCliCotizarMes($connMysql, $FechaActual)
{
    $sesion = $_SESSION['UsuarioLogueado'];
    // var_dump($sesion);

    if ($sesion == 'admin') {
        $SQL  = "SELECT * from est_gestiones WHERE DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual') AND estado = 'Cotizado'";
    } else {
        $SQL  = "SELECT * from est_gestiones WHERE asignadoA = '$sesion' AND DATE_FORMAT(created,'%y-%m') = DATE('$FechaActual') AND estado = 'Cotizado'";
    }
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $CantidadTotal;
}
