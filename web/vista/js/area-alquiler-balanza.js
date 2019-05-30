jQuery(document).ready(function($) {
    listar();
});

$("#btnAgregar").click(function(event) {
    $("#txttipooperacion").val("agregar");
    $("#modal_nombre").val("")
    $("#modal_precio_base").val("")
    $("#modal_precio_retraso").val("")
    $("#modal_estado").val("H")
    $("#modal_titulo").text("nueva area");
});

function listar() {

    var ruta = DIRECCION_WS + "area.alquiler.balanza.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Nombre</th>';
            html += '<th>Precio Base</th>';
            html += '<th>Precio Retraso</th>';
            html += '<th>Estado</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.nombre + '</td>';
                html += '<td>' + item.precio_base + '</td>';
                html += '<td>' + item.precio_retraso + '</td>';
                if (item.estado === 'H') {
                    html += '<td><span class="badge2 label-table badge-success">Habilitado</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger">Inhabilitado</span></td>';
                }
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning" data-toggle="modal" data-target="#signup-modal" onclick="leerDatos(' + item.id_area_alquiler_balanza + ')"> <i class="fa fa-wrench"></i> </button>';
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

$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    if ($("#txttipooperacion").val() == "agregar") {

        var ruta = DIRECCION_WS + "area.alquiler.balanza.agregar.php";
        var nombre = $("#modal_nombre").val()

        if (nombre == '') {
            nombre = "BALANZA"
        }

        var precio_base = $("#modal_precio_base").val()
        var precio_retraso = $("#modal_precio_retraso").val()
        var estado = $("#modal_estado").val()
        var numero_balanza = $("#modal_numero_balanza").val()

        swal({
            title: '¿Desea Registrar?',
            text: "se agregará una nueva caja!",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'registrar',
            cancelButtonText: 'cancelar',
            imageUrl: "../vista/imagenes/pregunta.png"
        }).then(function() {
            $.post(ruta, { nombre: nombre, precio_base: precio_base, precio_retraso: precio_retraso, estado: estado }, function() {}).done(function(resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal({
                        title: 'EXITO!',
                        text: datosJSON.mensaje,
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });
                    $("#modal_nombre").val("")
                    $("#modal_precio_base").val("")
                    $("#modal_precio_retraso").val("")
                    $("#signup-modal").modal("hide")
                    listar(); //refrescar los datos
                } else {
                    swal("Mensaje del sistema", resultado, "warning");
                }
            }).fail(function(error) {
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            })
        })

    } else {
        var ruta = DIRECCION_WS + "area.alquiler.balanza.editar.php";
        var id_area_alquiler_balanza = $("#modal_id_producto").val()
        var nombre = $("#modal_nombre").val()

        if (nombre == '') {
            nombre = "BALANZA"
        }

        var precio_base = $("#modal_precio_base").val()
        var precio_retraso = $("#modal_precio_retraso").val()
        var estado = $("#modal_estado").val()

        swal({
            title: '¿Desea Modificar?',
            text: "se modificara la caja " + nombre,
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'registrar',
            cancelButtonText: 'cancelar',
            imageUrl: "../vista/imagenes/pregunta2_1.png"
        }).then(function() {
            $.post(ruta, { id_area_alquiler_balanza: id_area_alquiler_balanza, nombre: nombre, precio_base: precio_base, precio_retraso: precio_retraso, estado: estado }, function() {}).done(function(resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal({
                        title: 'EXITO!',
                        text: datosJSON.mensaje,
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });
                    $("#modal_nombre").val("")
                    $("#modal_precio_base").val("")
                    $("#modal_precio_retraso").val("")
                    $("#signup-modal").modal("hide")
                    listar(); //refrescar los datos
                } else {
                    swal("Mensaje del sistema", resultado, "warning");
                }
            }).fail(function(error) {
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            })
        })
    }
});

function leerDatos(id_area_alquiler_balanza) {

    var ruta = DIRECCION_WS + "area.alquiler.balanza.leerdatos.php";

    $.post(ruta, { id_area_alquiler_balanza: id_area_alquiler_balanza }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {
                $("#txttipooperacion").val("editar");

                $("#modal_id_producto").val(item.id_area_alquiler_balanza);
                $("#modal_nombre").val(item.nombre);
                $("#modal_precio_base").val(item.precio_base);
                $("#modal_precio_retraso").val(item.precio_retraso);
                $("#modal_estado").val(item.estado);

                $("#modal_titulo").text("Editar Area");
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}