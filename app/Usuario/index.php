<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Usuarios</title>
    <link href="../../dist/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/assets/css/datatables.css" rel="stylesheet" type="text/css">
    <link href="../../dist/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
</head>

<body>

    <div class="container">

        <nav class="navbar navbar-expand-lg bg-info mt-4 mb-2">
            <div class="container-fluid">
                <h1 class="navbar-brand text-light">SISTEMA</h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                </div>
            </div>
        </nav>

        <!-- Main component for a primary marketing message or call to action -->
        <div class="modal fade" id="ModalUsuario" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong id="tituloUsuario"></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" id="idUser" value="NA">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Nombre:</label>
                                    <input type="text" id="nombre" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="">Usuario:</label>
                                    <input type="text" id="usuario" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="">Fecha:</label>
                                    <input type="date" id="fecha" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" id="BtnAccionUsuario" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <button type="button" id="btnModalUsuario" class="btn btn-outline-success mt-5">Agregar Usuario</button>
            <div class="table-responsive mb-4 mt-4">
                <table id="UsuariosTable" class="table " style="width:100%">
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
    <script src="../../dist/assets/js/jquery-3.1.1.min.js"></script>
    <script src="../../dist/assets/js/popper.min.js"></script>
    <script src="../../dist/assets/js/bootstrap.min.js"></script>
    <script src="../../dist/assets/js/datatables.js"></script>
    <script src="../../dist/assets/js/sweetalert2.min.js"></script>
    <script src="../../dist/js/func_usuarios/func_usuarios.js?v=1"></script>



</body>

</html>