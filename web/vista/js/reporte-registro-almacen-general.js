jQuery(document).ready(function($) {
    listar();
});

//
$("#btnfiltro_hoy").click(function(event) {
    var ruta = DIRECCION_WS + "../reportes/reporte.almacen.general.registro.php";

    $.post(ruta, function() {}).done(function() {

        window.open(DIRECCION_WS + "../reportes/reporte-almacen-general.pdf")

    }).fail(function(error) {
        alert(error.responseText);
    })
});

$("#btnfiltro_descargas").click(function(event) {
    var fecha_inicio = $("#datepicker-autoclose").val()
    fecha_inicio = fecha_inicio.split("/").reverse().join("-")

    var fecha_final = $("#datepicker-autoclose2").val()
    fecha_final = fecha_final.split("/").reverse().join("-")

    var ruta = DIRECCION_WS + "../reportes/reporte.almacen.general.registro.fechas.php";

    $.post(ruta, { fecha_inicio: fecha_inicio, fecha_final: fecha_final }, function() {}).done(function() {

        window.open(DIRECCION_WS + "../reportes/reporte-almacen-general.pdf")

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

$("#btnfiltro").click(function(event) {

    var fecha_inicio = $("#datepicker-autoclose").val()
    fecha_inicio = fecha_inicio.split("/").reverse().join("-")

    var fecha_final = $("#datepicker-autoclose2").val()
    fecha_final = fecha_final.split("/").reverse().join("-")

    var ruta = DIRECCION_WS + "reporte.almacen.general.listar.fecha.php";

    $.post(ruta, { fecha_inicio: fecha_inicio, fecha_final: fecha_final }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>N°</th>';
            html += '<th>Contacto</th>';
            html += '<th>Producto</th>';
            html += '<th>Cantidad</th>';
            html += '<th>Operación</th>';
            html += '<th>Stock Anterior</th>';
            html += '<th>Stock Actual</th>';
            html += '<th>Fecha y Hora</th>';
            html += '<th>Area</th>';
            html += '<th>Observaciones</th>';
            html += '<th>Usuario</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_registro + '</td>';
                html += '<td>' + item.contacto + '</td>';
                html += '<td>' + item.nombre_producto + '</td>';
                html += '<td>' + item.cantidad + '</td>';
                if (item.operacion === 'I') {
                    html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>INGRESO</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-down-thick"></i>SALIDA</span></td>';
                }
                html += '<td>' + item.stock_anterior + '</td>';
                html += '<td>' + item.stock_actual + '</td>';
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.nombre_area + '</td>';
                html += '<td>' + item.observaciones + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning"> <i class="fa fa-wrench"></i> </button>';
                html += '&nbsp;'
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-remove"></i> </button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';

            $("#listado").html(html);

            $('#responsive-datatable').DataTable({
                "language": {

                    "decimal": "",
                    "emptyTable": "No existe datos",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ total registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontro coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": columna ascedente",
                        "sortDescending": ": columna descente"
                    }

                }
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
})

function listar() {

    var ruta = DIRECCION_WS + "reporte.almacen.general.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>N°</th>';
            html += '<th>Contacto</th>';
            html += '<th>Producto</th>';
            html += '<th>Cantidad</th>';
            html += '<th>Operación</th>';
            html += '<th>Stock Anterior</th>';
            html += '<th>Stock Actual</th>';
            html += '<th>Fecha y Hora</th>';
            html += '<th>Area</th>';
            html += '<th>Observaciones</th>';
            html += '<th>Usuario</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_registro + '</td>';
                html += '<td>' + item.contacto + '</td>';
                html += '<td>' + item.nombre_producto + '</td>';
                html += '<td>' + item.cantidad + '</td>';
                if (item.operacion === 'I') {
                    html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>INGRESO</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-down-thick"></i>SALIDA</span></td>';
                }
                html += '<td>' + item.stock_anterior + '</td>';
                html += '<td>' + item.stock_actual + '</td>';
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.nombre_area + '</td>';
                html += '<td>' + item.observaciones + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning"> <i class="fa fa-wrench"></i> </button>';
                html += '&nbsp;'
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-remove"></i> </button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';

            $("#listado").html(html);

            $('#responsive-datatable').DataTable({
                "language": {

                    "decimal": "",
                    "emptyTable": "No existe datos",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ total registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontro coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": columna ascedente",
                        "sortDescending": ": columna descente"
                    }

                }
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}