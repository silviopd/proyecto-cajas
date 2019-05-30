jQuery(document).ready(function($) {
    listar();
    select_producto()
    select_cliente()
    select_area()
    select_area2()
});

$("#btnAgregar").click(function(event) {
    $("#txttipooperacion").val("agregar");

    $("#modal_producto").val("BALANZA").trigger('change');
    $("#modal_cliente").val("").trigger('change');
    $("#modal_area").val("").trigger('change');
    $("#modal_observacion").val("");

    $("#modal_titulo").text("nuevo alquiler");

});

function select_area() {
    var ruta = DIRECCION_WS + "area.autocompletar.alquiler.balanza.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_area">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_area_alquiler_balanza + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_area").html(html);

            $("#modal_area").select2({
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

function select_area2() {
    var ruta = DIRECCION_WS + "area.autocompletar.alquiler.balanza.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_area2">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_area_alquiler_balanza + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_area2").html(html);

            $("#modal_area2").select2({
                dropdownParent: $("#signup-modal2")
            })

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function select_cliente() {
    var ruta = DIRECCION_WS + "cliente.autocompletar.alquiler.balanza.listar.php";

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
    var ruta = DIRECCION_WS + "producto.autocompletar.alquiler.balanza.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_producto">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.nombre + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_producto").html(html);

            $("#modal_producto").select2({
                dropdownParent: $("#signup-modal")
            }).on('change', function(event) {
                event.preventDefault();

                var nombre_producto = $("#modal_producto").val();

                select_numero(nombre_producto);
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function select_numero(nombre_producto) {
    var ruta = DIRECCION_WS + "producto.numero.autocompletar.alquiler.balanza.listar.php";

    $.post(ruta, { nombre_producto: nombre_producto }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_numero">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_producto + '">' + item.numero_balanza + '</option>';
            });

            html += '</select>';

            $("#modal_select_numero").html(html);

            $("#modal_numero").select2({
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

    var ruta = DIRECCION_WS + "registro.alquiler.balanza.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>N°</th>';
            html += '<th>Cliente</th>';
            html += '<th>Area</th>';
            html += '<th>Producto</th>';
            html += '<th>Número</th>';
            html += '<th>Adicional</th>';
            html += '<th>SubTotal</th>';
            html += '<th>ESTADO</th>';
            html += '<th>Fecha y Hora</th>';
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
                html += '<td>' + item.nombre_cliente + '</td>';
                html += '<td>' + item.nombre_area + '</td>';
                html += '<td>' + item.nombre_producto + '</td>';
                html += '<td>' + item.numero_producto + '</td>';
                html += '<td>' + item.adicional + '</td>';
                html += '<td>' + item.sub_total + '</td>';
                if (item.estado === 'P') {
                    html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>PENDIENTE</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-up-thick"></i>DEVUELTO</span></td>';
                }
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.observaciones + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                if (item.estado === 'P') {
                    html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-info" onclick="devolver(' + item.id_registro + ')"> <i class="mdi mdi-account-check"></i> DEVOLVER </button>';
                    html += '&nbsp;'
                    html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-info" onclick="leerDatos(' + item.id_registro + ')" data-toggle="modal" data-target="#signup-modal2" > <i class="mdi mdi-account-check"></i> EDITAR </button>';
                } else {
                    html += '<button type="button" hidden></button>';
                }
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

$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    if ($("#txttipooperacion").val() == "agregar") {

        var ruta = DIRECCION_WS + "registro.alquiler.balanza.agregar.php";

        var id_area_alquiler_balanza = $("#modal_area").val();
        var id_producto = $("#modal_numero").val();
        var id_usuario_area = Cookies.get('id_usuario_area');
        var observaciones = $("#modal_observacion").val();
        var id_cliente = $("#modal_cliente").val();

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
            $.post(ruta, { id_producto: id_producto, id_area_alquiler_balanza: id_area_alquiler_balanza, id_usuario_area: id_usuario_area, observaciones: observaciones, id_cliente: id_cliente }, function() {}).done(function(resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal({
                        title: 'EXITO!',
                        text: datosJSON.mensaje,
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });

                    $("#modal_producto").val("BALANZA").trigger('change');
                    $("#modal_cliente").val("").trigger('change');
                    $("#modal_observacion").val("");

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

function devolver(id_registro) {

    var ruta = DIRECCION_WS + "registro.alquiler.balanza.mora.precio.php";
    $.post(ruta, { id_registro: id_registro }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {

            var precio = datosJSON.datos[0].precio
            var mora = datosJSON.datos[0].mora
            var dias_mora = datosJSON.datos[0].dias_mora
            var sub_total = datosJSON.datos[0].sub_total
            var adicional = datosJSON.datos[0].adicional
            var subtotal_adicional = datosJSON.datos[0].subtotal_adicional
            var mensaje = ""

            if (mora == 1) {
                mensaje = "Pago (MORA - " + dias_mora + " Dia(s) ) => " + sub_total + "<br>"
            } else {
                mensaje = "Pago => " + sub_total + "<br>"
            }

            if (adicional > 0) {
                mensaje = mensaje + "<br> Adicional => " + adicional + "<br>"
            }

            mensaje = mensaje + "<br> Total => " + subtotal_adicional + "<br>"

            swal({
                title: "¿DEVOLUCIÓN?",
                html: mensaje,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'registrar',
                cancelButtonText: 'cancelar',
                imageUrl: "../vista/imagenes/pregunta.png"
            }).then(function() {

                var ruta = DIRECCION_WS + "registro.alquiler.balanza.devolver.php";

                $.post(ruta, { id_registro: id_registro }, function() {}).done(function(resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {

                        swal({
                            title: 'EXITO!',
                            text: datosJSON.mensaje,
                            type: 'success',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        });

                        listar()

                        ruta = DIRECCION_WS + "../ticket/ticket_alquiler_balanza.php";
                        openWindowWithPost(ruta, {
                            id_registro: id_registro,
                        });

                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function(error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Error", datosJSON.mensaje, "error");
                })

            })
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function leerDatos(id_registro) {

    $("#modal_adicional").val("")

    var ruta = DIRECCION_WS + "registro.alquiler.balanza.leerdatos.php";

    $.post(ruta, { id_registro: id_registro }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {

                $("#modal_id_registro").val(datosJSON.datos[0].id_registro);
                $("#modal_producto2").val(datosJSON.datos[0].nombre_producto);
                $("#modal_nro2").val(datosJSON.datos[0].numero_producto);
                $("#modal_cliente2").val(datosJSON.datos[0].nombre_cliente);
                $("#modal_adicional").val(datosJSON.datos[0].adicional);
                $("#modal_observacion2").val(datosJSON.datos[0].observaciones);

                $("#modal_area2").val(datosJSON.datos[0].id_area_alquiler_balanza).trigger('change');
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

    var ruta = DIRECCION_WS + "registro.alquiler.balanza.editar.php";

    var id_registro = $("#modal_id_registro").val()
    var adicional = $("#modal_adicional").val()
    var observaciones = $("#modal_observacion2").val();

    var id_area_alquiler_balanza = $("#modal_area2").val()

    swal({
        title: "EDITAR?",
        text: "se editara este registro",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-confirm mt-2',
        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
        confirmButtonText: 'registrar',
        cancelButtonText: 'cancelar',
        imageUrl: "../vista/imagenes/pregunta.png"
    }).then(function() {

        $.post(ruta, { id_registro: id_registro, id_area_alquiler_balanza: id_area_alquiler_balanza, adicional: adicional, observaciones: observaciones }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {

                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });

                $("#signup-modal2").modal("hide")
                listar()

            } else {
                swal("Mensaje del sistema", resultado, "warning");
            }
        }).fail(function(error) {
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        })

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