
var DatosPeticion = {
                PostMethod: "UsuariosTable",
            };
 $("#UsuariosTable").DataTable().destroy();
 var ConfiguracionesTableProspectadoresInicio = $("#UsuariosTable"). DataTable({

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
// $(document).ready(function () {

//     setTimeout(() => {
//         // $("#BtnGuardarCliente").trigger("click");
//         GetProspectos();
//         GetProspectosMes();
//     }, 500);

//     TableInicio();
//     TableInicioP();
//     //#################################################################### Documentos ###########################################################################################

//     var f3 = flatpickr($(".DatePickerHour"), {
//         enableTime: false,
//         dateFormat: "Y-m-d",
//         locale: {
//             firstDayOfWeek: 1,
//             weekdays: {
//                 shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
//                 longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
//             },
//             months: {
//                 shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
//                 longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
//             },
//         }
//     });



//     // document.getElementById('fechaInicio').value = Fecha;


//     function TableInicio() {
//         var fecha = new Date(); //Fecha actual
//         // console.log(fecha);

//         var mes = fecha.getMonth() + 1; //obteniendo mes
//         var dia = fecha.getDate(); //obteniendo dia
//         var dia2 = fecha.getDate() + 1;//obteniendo dia
//         var ano = fecha.getFullYear(); //obteniendo año
//         if (dia < 10)
//             dia = '0' + dia; //agrega cero si el menor de 10
//         if (mes < 10)
//             mes = '0' + mes //agrega cero si el menor de 10
//         if (document.getElementById('fechaInicio').value == '') {
//             document.getElementById('fechaInicio').value = ano + "-" + mes + "-" + dia;
//         }
//         if (document.getElementById('fechaFin').value == '') {
//             document.getElementById('fechaFin').value = ano + "-" + mes + "-" + dia2;
//         }
//         $('select option[value="Prospectacion"]').attr("selected", true);
//         var TablaTipo = $("#TablaTipo").val();


//         var fechaInicio = $("#fechaInicio").val();
//         var fechaFin = $("#fechaFin").val();
//         // console.log(fechaInicio);
//         var DatosPeticion2 = {
//             PostMethod: "ConfiguracionesTableInicio",
//             'fechaInicio': fechaInicio,
//             'fechaFin': fechaFin,
//             'TablaTipo': TablaTipo,
//         };
//         // console.log(DatosPeticion2);
//         $("#ConfiguracionesTableInicio").DataTable().destroy();
//         var ConfiguracionesTableInicio = $("#ConfiguracionesTableInicio").DataTable({
//             scrollCollapse: true,
//             oLanguage: {
//                 oPaginate: {
//                     sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
//                     sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
//                 },
//                 sInfo: "Mostrando página _PAGE_ de _PAGES_",
//                 sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
//                 sSearchPlaceholder: "Buscar...",
//                 sLengthMenu: "Resultados :  _MENU_",
//             },
//             stripeClasses: [],
//             lengthMenu: [10, 20, 30, 50],
//             pageLength: 50,
//             "order": [
//                 [2, 'desc']
//             ],
//             ajax: {
//                 url: "../../dist/php/controller.php?inicio",
//                 type: "POST",
//                 data: DatosPeticion2,
//             },
//         });
//     }


//     $("#filtar").click(function () {
//         var fechaInicio = $("#fechaInicio").val();
//         var fechaFin = $("#fechaFin").val();
//         // console.log(dia);
//         if (fechaInicio == '') {
//             $("#fechaInicio").focus();
//             swal("Error!", "Seleccione una fecha inicio para filtrar", "warning");
//         }
//         else if (fechaFin == '') {
//             $("#fechaFin").focus();
//             swal("Error!", "Seleccione una fecha fin para filtrar", "warning");
//         }
//         else if (fechaFin < fechaInicio) {
//             $("#fechaFin").focus();
//             swal("Error!", "La fecha fin no debe ser menor a la fecha inicial", "warning");
//         }
//         else {
//             TableInicio();
//         }
//     });


















//     function TableInicioP() {
//         var fecha = new Date(); //Fecha actual
//         var mes = fecha.getMonth() + 1; //obteniendo mes
//         var dia = fecha.getDate(); //obteniendo dia
//         // console.log(dia);
//         var dia2 = fecha.getDate() + 1;//obteniendo dia
//         var ano = fecha.getFullYear(); //obteniendo año
//         if (dia < 10)
//             dia = '0' + dia; //agrega cero si el menor de 10
//         if (dia2 < 10)
//             dia2 = '0' + dia2; //agrega cero si el menor de 10
//         console.log(dia2);

//         if (mes < 10)
//             mes = '0' + mes //agrega cero si el menor de 10
//         if (document.getElementById('fechaInicioProspectadores').value == '') {
//             document.getElementById('fechaInicioProspectadores').value = ano + "-" + mes + "-" + dia;
//         }
//         if (document.getElementById('fechaFinProspectadores').value == '') {
//             document.getElementById('fechaFinProspectadores').value = ano + "-" + mes + "-" + dia2;
//         }


//         var fechaInicioProspectadores = $("#fechaInicioProspectadores").val();
//         var fechaFinProspectadores = $("#fechaFinProspectadores").val();
//         // console.log(fechaInicio);
//         var DatosPeticion2 = {
//             PostMethod: "ConfiguracionesTableProspectadoresInicio",
//             'fechaInicioProspectadores': fechaInicioProspectadores,
//             'fechaFinProspectadores': fechaFinProspectadores,
//         };
//         console.log(DatosPeticion2);
       
//     }


//     $("#filtarProspectadores").click(function () {
//         var fechaInicio = $("#fechaInicioProspectadores").val();
//         var fechaFin = $("#fechaFinProspectadores").val();
//         // console.log(dia);
//         if (fechaInicio == '') {
//             $("#fechaInicioProspectadores").focus();
//             swal("Error!", "Seleccione una fecha inicio para filtrar", "warning");
//         }
//         else if (fechaFin == '') {
//             $("#fechaFinProspectadores").focus();
//             swal("Error!", "Seleccione una fecha fin para filtrar", "warning");
//         }
//         else if (fechaFin < fechaInicio) {
//             $("#fechaFinProspectadores").focus();
//             swal("Error!", "La fecha fin no debe ser menor a la fecha inicial", "warning");
//         }
//         else {
//             TableInicioP();
//         }
//     });

















//     function GetProspectos() {

//         var DatosPeticion = {
//             'PostMethod': 'GetProspectos',
//         };
//         $.ajax({
//             url: "../../dist/php/controller.php?GetProspectos",
//             method: "POST",
//             data: DatosPeticion,
//             cache: false,
//             dataType: "json",
//             success: function (data) {
//                 var ctx = document.getElementById('Diario');
//                 var Diario = new Chart(ctx, {
//                     type: 'bar',
//                     data: {
//                         labels: ['Prospectos', 'Clientes cotizados'],
//                         datasets: [{
//                             label: data.Prospecto+data.CliCot+' clientes diarios',
//                             data: [data.Prospecto, data.CliCot, data.SinCliCot],
//                             backgroundColor: [
//                                 'rgba(54, 162, 235, 0.2)',
//                                 'rgba(75, 192, 192, 0.2)',
//                                 'rgba(255, 206, 86, 0.2)',
//                                 'rgba(75, 192, 192, 0.2)',
//                                 'rgba(153, 102, 255, 0.2)',
//                                 'rgba(255, 159, 64, 0.2)'
//                             ],
//                             borderColor: [
//                                 'rgba(54, 162, 235, 1)',
//                                 'rgba(75, 192, 192)',
//                                 'rgba(255, 206, 86, 1)',
//                                 'rgba(75, 192, 192, 1)',
//                                 'rgba(153, 102, 255, 1)',
//                                 'rgba(255, 159, 64, 1)'
//                             ],
//                             borderWidth: 1
//                         }]
//                     },
//                     options: {
//                         scales: {
//                             y: {
//                                 beginAtZero: true
//                             }
//                         }
//                     }
//                 });
//             }
//         });
//     }




//     function GetProspectosMes() {

//         var DatosPeticion = {
//             'PostMethod': 'GetProspectosMes',
//         };
//         $.ajax({
//             url: "../../dist/php/controller.php?GetProspectosMes",
//             method: "POST",
//             data: DatosPeticion,
//             cache: false,
//             dataType: "json",
//             success: function (data) {
//                 var ctx = document.getElementById('Mensual');
//                 var Mensual = new Chart(ctx, {
//                     type: 'bar',
//                     data: {
//                         labels: ['Prospectos', 'Clientes cotizados'],
//                         datasets: [{
//                             label: data.Prospecto+data.CliCot+' clientes en total del mes',
//                             data: [data.Prospecto, data.CliCot],
//                             backgroundColor: [
//                                 'rgba(54, 162, 235, 0.2)',
//                                 'rgba(75, 192, 192, 0.2)',
//                                 'rgba(255, 206, 86, 0.2)',
//                                 'rgba(75, 192, 192, 0.2)',
//                                 'rgba(153, 102, 255, 0.2)',
//                                 'rgba(255, 159, 64, 0.2)'
//                             ],
//                             borderColor: [
//                                 'rgba(54, 162, 235, 1)',
//                                 'rgba(75, 192, 192)',
//                                 'rgba(255, 206, 86, 1)',
//                                 'rgba(75, 192, 192, 1)',
//                                 'rgba(153, 102, 255, 1)',
//                                 'rgba(255, 159, 64, 1)'
//                             ],
//                             borderWidth: 1
//                         }]
//                     },
//                     options: {
//                         scales: {
//                             y: {
//                                 beginAtZero: true
//                             }
//                         }
//                     }
//                 });
//             }
//         });
//     }

// })