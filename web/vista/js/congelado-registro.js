jQuery(document).ready(function($) {
    listar();

    select_cliente()
    select_producto()
});

function select_cliente() {
    var ruta = DIRECCION_WS + "cliente.autocompletar.congelado.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_cliente">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_cliente + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_cliente").html(html);

            $("#modal_cliente").select2({
                dropdownParent: $("#signup-modal")
            })

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function select_producto() {
    var ruta = DIRECCION_WS + "producto.autocompletar.congelado.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_producto">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_producto + '">' + item.nombre + ' (' + item.peso + ' Kg.)</option>';
            });

            html += '</select>';

            $("#modal_select_producto").html(html);

            $("#modal_producto").select2({
                dropdownParent: $("#signup-modal")
            })

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}



function listar() {

    var ruta = DIRECCION_WS + "registro.congelado.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Codigo</th>';
            html += '<th>Fecha</th>';
            html += '<th>Cliente</th>';
            html += '<th>Contacto</th>';
            html += '<th>Producto</th>';
            html += '<th>Peso (KG)</th>';
            html += '<th>Cantidad</th>';
            html += '<th>Cant. Actual</th>';
            html += '<th>Usuario</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_registro + '</td>';
                html += '<td>' + item.fecha + '</td>';
                html += '<td>' + item.cliente + '</td>';
                html += '<td>' + item.contacto + '</td>';
                html += '<td>' + item.producto + '</td>';
                html += '<td>' + item.peso + '</td>';
                html += '<td>' + item.cant + '</td>';
                html += '<td>' + item.cant_actual + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-success" data-toggle="modal" data-target="#signup-modal-ingreso" onclick="leerDatos(' + item.id_registro + ')"> <i class="fa fa-cloud-upload"></i> </button>';
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

                },
                "order": [
                    [0, "desc"]
                ]
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function leerDatos(id_registro) {

    $("#modal_contacto_ie").val("");
    $("#modal_cantidadtxt_ie").val("")
    $("#modal_observacion_ie").val("")

    var ruta = DIRECCION_WS + "registro.congelado.leerdatos.php";

    $.post(ruta, { id_registro: id_registro }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {
                $("#txttipooperacion_ie").val("editar");

                $("#modal_codigo_ie").val(item.id_registro);
                $("#modal_cantidad_ie").val(item.cant);

                $("#modal_titulo").text("Editar cliente2");
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

$("#frmgrabar2").submit(function(evento) {
    evento.preventDefault();

    if ($("#txttipooperacion_ie").val() == "editar") {

        var ruta = DIRECCION_WS + "registro.congelado.actualizar.php";

        var operacion = $("#modal_operacion_ie").val()
        var id_usuario_area = Cookies.get('id_usuario_area');
        var bloques = $("#modal_cantidadtxt_ie").val()
        var id_registro = $("#modal_codigo_ie").val()
        var contacto = $("#modal_contacto_ie").val()
        var observaciones = $("#modal_observacion_ie").val()

        //alert(id_usuario_area + " - " + bloques + " - " + id_registro + " - " + operacion)

        swal({
            title: '¿Aumentar o disminuir producto?',
            text: "se modificara este producto!",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'registrar',
            cancelButtonText: 'cancelar',
            imageUrl: "../vista/imagenes/pregunta.png"
        }).then(function() {
            $.post(ruta, {
                operacion: operacion,
                id_usuario_area: id_usuario_area,
                bloques: bloques,
                id_reg: id_registro,
                contacto: contacto,
                observaciones: observaciones
            }, function() {}).done(function(resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal({
                        title: 'EXITO!',
                        text: datosJSON.mensaje,
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });
                    $("#signup-modal-ingreso").modal("hide")
                    listar(); //refrescar los datos
                } else {
                    swal("Mensaje del sistema", resultado, "warning");
                }
            }).fail(function(error) {
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            })
        });
    }
});

$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    var ruta = DIRECCION_WS + "registro.congelado.agregar.php";

    var operacion = $("#modal_operacion").val()
    var contacto = $("#modal_contacto").val()
    var id_producto = $("#modal_producto").val()
    var id_usuario_area = Cookies.get('id_usuario_area');
    var bloques = $("#modal_cantidad").val()
    var observaciones = $("#modal_observacion").val()
    var id_cliente = $("#modal_cliente").val()

    //alert(id_usuario_area + " - " + bloques + " - " + id_registro + " - " + operacion)

    swal({
        title: '¿Desea Registrar?',
        text: "se agregará un nuevo registro!",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-confirm mt-2',
        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
        confirmButtonText: 'registrar',
        cancelButtonText: 'cancelar',
        imageUrl: "../vista/imagenes/pregunta.png"
    }).then(function() {
        $.post(ruta, {
            operacion: operacion,
            contacto: contacto,
            id_producto: id_producto,
            id_usuario_area: id_usuario_area,
            bloques: bloques,
            observaciones: observaciones,
            id_cliente: id_cliente
        }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
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
});