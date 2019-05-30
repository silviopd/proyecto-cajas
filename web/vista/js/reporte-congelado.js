jQuery(document).ready(function($) {
    listar();
});

// $("#btnfiltro_hoy").click(function(event) {
//     var ruta = DIRECCION_WS + "../reportes/reporte.almacen.registro.php";

//     $.post(ruta, function() {}).done(function() {

//         window.open(DIRECCION_WS + "../reportes/reporte-almacen.pdf")

//     }).fail(function(error) {
//         var datosJSON = $.parseJSON(error.responseText);
//         swal("Error", datosJSON.mensaje, "error");
//     })
// });

$("#btnfiltro_descargas").click(function(event) {
    // var fecha_inicio = $("#datepicker-autoclose").val()
    // fecha_inicio = fecha_inicio.split("/").reverse().join("-")

    // var fecha_final = $("#datepicker-autoclose2").val()
    // fecha_final = fecha_final.split("/").reverse().join("-")

    var ruta = DIRECCION_WS + "../reportes/reporte.congelado.php";

    $.post(ruta, function() {}).done(function() {

        window.open(DIRECCION_WS + "../reportes/congelado.pdf")

    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
});

function openWindowWithPost(url, data) {
    var form = document.createElement("form");
    form.target = "_blank";
    form.method = "POST";
    form.action = url;
    form.style.display = "none";

    for (var key in data) {
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// $("#btnfiltro").click(function(event) {

//     var fecha_inicio = $("#datepicker-autoclose").val()
//     fecha_inicio = fecha_inicio.split("/").reverse().join("-")

//     var fecha_final = $("#datepicker-autoclose2").val()
//     fecha_final = fecha_final.split("/").reverse().join("-")

//     var ruta = DIRECCION_WS + "reporte.almacen.listar.fecha.php";

//     $.post(ruta, { fecha_inicio: fecha_inicio, fecha_final: fecha_final }, function() {}).done(function(resultado) {
//         var datosJSON = resultado;
//          if (datosJSON.estado === 200) {
//             var html = "";

//             html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
//             html += '<thead>';
//             html += '<tr>';
//             html += '<th>Registro</th>';
//             html += '<th>Movimientos</th>';
//             html += '<th>Cliente</th>';
//             html += '<th>Contacto</th>';
//             html += '<th>Caja</th>';
//             html += '<th>Cantidad</th>';
//             html += '<th>Precio</th>';
//             html += '<th>SubTotal</th>';
//             html += '<th>Operación</th>';
//             html += '<th>Stock Anterior</th>';
//             html += '<th>Stock Actual</th>';
//             html += '<th>Fecha y Hora</th>';
//             html += '<th>Ubicación</th>';
//             html += '<th>Observaciones</th>';
//             html += '<th>Usuario</th>';
//             html += '</tr>';
//             html += '</thead>';
//             html += '<tbody>';

//             //Detalle
//             $.each(datosJSON.datos, function(i, item) {
//                 html += '<tr>';
//                 html += '<td>' + item.id_registro + '</td>';
//                 html += '<td>' + item.id_historial + '</td>';
//                 html += '<td>' + item.nombre_cliente + '</td>';
//                 html += '<td>' + item.contacto + '</td>';
//                 html += '<td>' + item.nombre_caja + '</td>';
//                 html += '<td>' + item.cantidad + '</td>';
//                 html += '<td>' + item.precio_base + '</td>';
//                 html += '<td>' + item.sub_total + '</td>';
//                 if (item.operacion === 'INGRESO') {
//                     html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>INGRESO</span></td>';
//                 } else {
//                     html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-down-thick"></i>SALIDA</span></td>';
//                 }
//                 html += '<td>' + item.stock_anterior + '</td>';
//                 html += '<td>' + item.stock_actual + '</td>';
//                 html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
//                 html += '<td>' + item.nombre_ubicacion + '</td>';
//                 html += '<td>' + item.observaciones + '</td>';
//                 html += '<td>' + item.nombre_usuario + '</td>';
//                 html += '</tr>';
//             });

//             html += '</tbody>';
//             html += '</table>';

//             $("#listado").html(html);

//             $('#responsive-datatable').DataTable({
//                 "order": [
//                     [0, "desc"]
//                 ]
//             });

//         } else {
//             swal("Mensaje del sistema", resultado, "warning");
//         }
//     }).fail(function(error) {
//         var datosJSON = $.parseJSON(error.responseText);
//         swal("Error", datosJSON.mensaje, "error");
//     })
// })

function listar() {

    var ruta = DIRECCION_WS + "reporte.congelado.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";
            var total = 0;

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Registro</th>';
            html += '<th>Movimientos</th>';
            html += '<th>Fecha</th>';
            html += '<th>Nombre</th>';
            html += '<th>Contacto</th>';
            html += '<th>Producto</th>';
            html += '<th>Peso (KG)</th>';
            html += '<th>Operacion</th>';
            html += '<th>Bloques</th>';
            html += '<th>Bloques Ant.</th>';
            html += '<th>Bloques Act.</th>';
            html += '<th>Observaciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_registro + '</td>';
                html += '<td>' + item.id_historial + '</td>';
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.nombre_cliente + '</td>';
                html += '<td>' + item.contacto + '</td>';
                html += '<td>' + item.nombre_producto + '</td>';
                html += '<td>' + item.peso + '</td>';
                html += '<td>' + item.operacion + '</td>';
                html += '<td>' + item.bloques + '</td>';
                html += '<td>' + item.bloques_anterior + '</td>';
                html += '<td>' + item.bloques_actual + '</td>';
                html += '<td>' + item.observaciones + '</td>';
                html += '</tr>';

                total = item.total;
            });

            html += '</tbody>';
            html += '</table>';

            $("#listado").html(html);

            $('#responsive-datatable').DataTable({
                "searching": false,
                "paging": false,
                "info": false
            });


        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function round(num, decimales) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}