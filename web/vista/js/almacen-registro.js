jQuery(document).ready(function() {
    select_cliente();
    select_caja();
    select_ubicacion();
    $("#modal_stock").text("0")
    listar();
});

$("#btnAgregar").click(function(event) {
    $("#txttipooperacion").val("agregar");

    $("#modal_cliente").val("").trigger('change');
    $("#modal_caja").val("").trigger('change');
    $("#modal_contacto").val("");
    $("#modal_ubicacion").val("").trigger('change');
    $("#modal_observacion").val("");
    $("#modal_operacion").val("I")
    $("#modal_stock").text("0")
    $("#modal_cantidad").val("")

    $("#modal_titulo").text("nuevo usuario area");

});

function select_cliente() {
    var ruta = DIRECCION_WS + "cliente.autocompletar.almacen.listar.php";

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



function select_caja() {
    var ruta = DIRECCION_WS + "caja.autocompletar.almacen.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_caja" placeholder="">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_caja + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_caja").html(html);

            $("#modal_caja").select2({
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


function select_ubicacion() {
    var ruta = DIRECCION_WS + "ubicacion.autocompletar.almacen.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_ubicacion" placeholder="">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_ubicacion + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_ubicacion").html(html);

            $("#modal_ubicacion").select2({
                dropdownParent: $("#signup-modal")
            }).on('change', function(event) {
                event.preventDefault();

                var id_ubicacion = $("#modal_ubicacion").val();

                var ruta2 = DIRECCION_WS + "ubicacion.capacidad.autocompletar.almacen.listar.php";

                $.post(ruta2, { id_ubicacion: id_ubicacion }, function() {}).done(function(resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        var capacidad = datosJSON.datos[0].capacidad;
                        $("#modal_stock").text(capacidad);
                    }
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


$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    var ruta = DIRECCION_WS + "registro.almacen.agregar.php";

    var id_cliente = $("#modal_cliente").val()
    var id_caja = $("#modal_caja").val()
    var contacto = $("#modal_contacto").val()
    var cantidad = $("#modal_cantidad").val()
    var id_ubicacion = $("#modal_ubicacion").val()
    var observacion = $("#modal_observacion").val()
    var operacion = $("#modal_operacion").val()
    var id_usuario_area = Cookies.get('id_usuario_area');

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

        $.post(ruta, { id_cliente: id_cliente, id_caja: id_caja, contacto: contacto, cantidad: cantidad, id_ubicacion: id_ubicacion, observacion: observacion, operacion: operacion, id_usuario_area: id_usuario_area }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
                //$("#modal_nombre").val("")
                listar(); //refrescar los datos
                $("#signup-modal").modal("hide")
            } else {
                swal("Mensaje del sistema", resultado, "warning");
            }
        }).fail(function(error) {
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        })
    });
});

$("#frmgrabar2").submit(function(evento) {
    evento.preventDefault();

    var ruta = DIRECCION_WS + "registro.almacen.ingresar.retirar.php";

    var id_registro = $("#txtid_registro").val();
    var contacto = $("#modal_contacto2").val()
    var cantidad = $("#modal_cantidad2").val()
    var observacion = $("#modal_observacion2").val()
    var operacion = $("#modal_operacion2").val()
    var id_usuario_area = Cookies.get('id_usuario_area');

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

        $.post(ruta, { id_registro: id_registro, contacto: contacto, cantidad: cantidad, observacion: observacion, operacion: operacion, id_usuario_area: id_usuario_area }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });

                //$("#modal_nombre").val("")
                listar(); //refrescar los datos
                $("#signup-modal2").modal("hide")

                if (operacion == "S") {
                    ruta = DIRECCION_WS + "../ticket/ticket_caja.php";
                    openWindowWithPost(ruta, {
                        id_registro: id_registro
                    });
                }
            } else {
                swal("Mensaje del sistema", resultado, "warning");
            }
        }).fail(function(error) {
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        })
    });
});

function listar() {

    var ruta = DIRECCION_WS + "registro.almacen.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>N°</th>';
            html += '<th>Cliente</th>';
            html += '<th>Contacto</th>';
            html += '<th>Caja</th>';
            html += '<th>Cantidad</th>';
            //html += '<th>Precio</th>';
            //html += '<th>SubTotal</th>';
            html += '<th>Operación</th>';
            html += '<th>Stock Anterior</th>';
            html += '<th>Stock Actual</th>';
            html += '<th>Fecha y Hora</th>';
            html += '<th>Ubicación</th>';
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
                html += '<td>' + item.contacto + '</td>';
                html += '<td>' + item.nombre_caja + '</td>';
                html += '<td>' + item.cantidad + '</td>';
                //html += '<td>' + item.precio_base + '</td>';
                //html += '<td>' + item.sub_total + '</td>';
                if (item.operacion === 'I') {
                    html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>INGRESO</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-down-thick"></i>SALIDA</span></td>';
                }
                html += '<td>' + item.stock_anterior + '</td>';
                html += '<td>' + item.stock_actual + '</td>';
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.nombre_ubicacion + '</td>';
                html += '<td>' + item.observaciones + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-confirm" data-toggle="modal" data-target="#signup-modal2" onclick="cajas(' + item.id_registro + ')"> <i class=" mdi mdi-clipboard-flow"></i>  </button>';
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
                 "order": [[ 0, "desc" ]]
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}


function cajas(id_registro) {

    $("#modal_contacto2").val("")
    $("#modal_cantidad3").val("")
    $("#modal_observacion2").val("")
    $("#modal_operacion2").val("I")

    var ruta = DIRECCION_WS + "registro.almacen.leerdatos.php";

    $.post(ruta, { id_registro: id_registro }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {

            $("#modal_stock2").text(datosJSON.datos[0].capacidad);
            $("#modal_stock3").text(datosJSON.datos[0].stock_actual);
            $("#modal_ubicacion2").text(datosJSON.datos[0].nombre_ubicacion);

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })

    $("#txtid_registro").val(id_registro);
}

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