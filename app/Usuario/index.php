<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Usuarios | INICIO</title>
    <link href="../../dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/plugins/table/datatable/datatables.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="container">

        <nav class="navbar navbar-expand-lg bg-info mt-4 mb-2">
            <div class="container-fluid">
                <h2 class="navbar-brand">Sistema</h2>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Usuarios</a>
                        </li>



                    </ul>

                </div>
            </div>
        </nav>

        <!-- Main component for a primary marketing message or call to action -->
        <div class="main-content">
        <button type="button" class="btn btn-outline-success mt-5">Agregar Usuario</button>
            <div class="table-responsive mb-4 mt-4">
                <table id="UsuariosTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>

                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../../dist/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../../dist/bootstrap/js/popper.min.js"></script>
    <script src="../../dist/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../dist/plugins/table/datatable/datatables.js"></script>
    <script src="../../dist/js/func_usuarios/func_usuarios.js?v=1"></script>
    


</body>

</html>