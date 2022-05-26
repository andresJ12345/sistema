
var DatosPeticion = {
    PostMethod: "UsuariosTable",
};
$("#UsuariosTable").DataTable().destroy();
var ConfiguracionesTableProspectadoresInicio = $("#UsuariosTable").DataTable({

    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Mostrado pagina _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Results :  _MENU_",
        "sEmptyTable": '<div class="alert alert-warning mb-4" role="alert"> <h4 class="text-white"><strong>Sin datos! </strong>Tabla de usuarios Vacia</h4></div>'
    },

    "stripeClasses": [],
    "lengthMenu": [10, 20, 30, 40],
    "pageLength": 30,
    "order": [
        [1, 'desc']
    ],
    "ajax": {
        url: "../../dist/php/controller.php?UsuariosTable",
        data: DatosPeticion, //  Fuente de datos json
        type: "post",

    }
});

$(document).on('click', '#btnModalUsuario', function (e) {
    e.preventDefault();
    $('#BtnAccionUsuario').text('Agregar')
    $('#tituloUsuario').text('Agregar Usuario:')
    $('#nombre').val('')
    $('#usuario').val('')
    $('#fecha').val('')
    $('#idUser').val('NA')
    $("#ModalUsuario").modal({
        backdrop: 'static',
        keyboard: false
    });

});

$(document).on('click', '#BtnAccionUsuario', function (e) {
    e.preventDefault();
    var nombre = $('#nombre').val()
    var usuario = $('#usuario').val()
    var fecha = $('#fecha').val()
    var idUser = $('#idUser').val()
    if (nombre == '') {
        swal("Error!", "El campo nombre no puede estar vacío", "warning");
    }
    else if (usuario == '') {
        swal("Error!", "El campo usuario no puede estar vacío", "warning");
    }
    else if (fecha == '') {
        swal("Error!", "El fecha no puede estar vacío", "warning");
    }
    else {
        var DatosPeticion = {
            'PostMethod': 'AccionesUsuario',
            'nombre': nombre,
            'usuario': usuario,
            'fecha': fecha,
            'idUser': idUser,

        };
        // console.log(DatosPeticion)
        $.ajax({
            url: "../../dist/php/controller.php?AccionesUsuario",
            method: "POST",
            data: DatosPeticion,
            cache: false,
            // dataType: "json",
            success: function (data) {
                $("#ModalUsuario").modal('hide');
                $("#UsuariosTable").DataTable().ajax.reload();;
                $('#idUser').val('NA')
            }
        });
    }


});
$(document).on('click', '.BtnEditarUSuario', function (e) {
    e.preventDefault();
    var idUser = $(this).data('id')
    $('#idUser').val(idUser)
    var DatosPeticion = {
        'PostMethod': 'DetalleUSuario',
        'idUser': idUser,
    }
    $.ajax({
        url: "../../dist/php/controller.php?DetalleUSuario",
        method: "POST",
        data: DatosPeticion,
        cache: false,
        dataType: "json",
        success: function (data) {
            $('#nombre').val(data.nombre)
            $('#usuario').val(data.usuario)
            $('#fecha').val(data.fecha)
            $('#BtnAccionUsuario').text('Editar')
            $('#tituloUsuario').text('Editar Usuario:')
            $("#ModalUsuario").modal({
                backdrop: 'static',
                keyboard: false
            });

        }
    });



});
$(document).on('click', '.BtnEliminarUSuario', function (e) {
    e.preventDefault();
    var idUser = $(this).data('id')

    swal({
        title: 'Esta seguro de eliminar',
        text: "se guardaran cambios",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        padding: '2em'
    }).then(function (result) {
        if (result.value) {
            swal.close();
            var DatosPeticion = {
                'PostMethod': 'EliminarUSuario',
                'idUser': idUser,
            }
            $.ajax({
                url: "../../dist/php/controller.php?EliminarUSuario",
                method: "POST",
                data: DatosPeticion,
                cache: false,
                // dataType: "json",
                success: function (data) {

                    $("#UsuariosTable").DataTable().ajax.reload();;

                }
            });
        } else {
            swal("Cancelado", "Se canceló la operación", "error");
        }
    })

});



