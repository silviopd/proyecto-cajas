jQuery(document).ready(function($) {
    select_tipo_categoria()
    select_tipo_carga()
    listar()
    document.getElementById("modal_cantidad").defaultValue = "1";
});


function select_tipo_categoria() {
    var ruta = DIRECCION_WS + "tipo.categoria.autocompletar.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_tipo_categoria">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_tipo_categoria + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_tipo_categoria").html(html);

            $("#modal_tipo_categoria").select2({
                dropdownParent: $("#signup-modal")
            }).on('change', function(event) {
                event.preventDefault();

                var ruta = DIRECCION_WS + "tipo.categoria.buscar.precio.php";
                var id_tipo_categoria = $("#modal_tipo_categoria").val()

                $.post(ruta, { id_tipo_categoria: id_tipo_categoria }, function() {}).done(function(resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        $("#modal_precio_tipo_categoria").text(datosJSON.datos.precio)
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function(error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Error", datosJSON.mensaje, "error");
                })
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function select_tipo_carga() {
    var ruta = DIRECCION_WS + "tipo.carga.autocompletar.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_tipo_carga">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_tipo_carga + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_tipo_carga").html(html);

            $("#modal_tipo_carga").select2({
                dropdownParent: $("#signup-modal")
            }).on('change', function(event) {
                event.preventDefault();

                var ruta = DIRECCION_WS + "tipo.carga.buscar.precio.php";
                var id_tipo_carga = $("#modal_tipo_carga").val()

                $.post(ruta, { id_tipo_carga: id_tipo_carga }, function() {}).done(function(resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        $("#modal_precio_tipo_carga").text(datosJSON.datos.precio)
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function(error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Error", datosJSON.mensaje, "error");
                })
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

$("#btnAgregar").click(function(event) {
    $("#txttipooperacion").val("agregar");

    $("#modal_tipo_carga").val("").trigger('change');
    $("#modal_precio_tipo_carga").text("0.00")
    $("#modal_tipo_categoria").val("").trigger('change');
    $("#modal_precio_tipo_categoria").text("0.00")

    $('#modal_cobrar').val("C")
    $('#pendiente').hide()
    $('#ahora').show()

    $("#modal_nro_placa").val("");
    $("#modal_nro_placa").removeAttr('disabled');
    $("#modal_cobrar").removeAttr('disabled');

    $("#modal_titulo").text("nueva registro");
});

$('#modal_cobrar').on('change', function() {
    var cobrar = $('#modal_cobrar').val()

    if (cobrar == "P") {
        $('#modal_cantidad').prop('required', false);
        $('#pendiente').show()
        $('#ahora').hide()
        $("#modal_tipo_categoria").val("").trigger('change');
        $("#modal_precio_tipo_categoria").text("0.00")

        $("#modal_tipo_carga").val(1).trigger('change');
        $("#modal_tipo_carga").attr('disabled', 'disabled');

        $("#modal_nro_placa").removeAttr('disabled');
        $("#modal_cobrar").removeAttr('disabled');

    } else {
        $('#modal_cantidad').prop('required', true);
        $('#pendiente').hide()
        $('#ahora').show()
        $("#modal_tipo_carga").val("").trigger('change');
        $("#modal_precio_tipo_carga").text("0.00")
    }
})

$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    if ($("#txttipooperacion").val() == "agregar") {

        var ruta = DIRECCION_WS + "salida.puerta4.agregar.php";

        var nro_placa = $("#modal_nro_placa").val()
        var estado = $('#modal_cobrar').val()
        var id_tipo_carga = 1
        var cantidad = 1
        var id_tipo_categoria = 1
        var id_usuario_area = Cookies.get('id_usuario_area');
        if (estado == "P") {
            id_tipo_carga = 1
        } else {
            cantidad = $("#modal_cantidad").val()
            id_tipo_categoria = $("#modal_tipo_categoria").val()
        }



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
            $.post(ruta, { nro_placa: nro_placa, estado: estado, id_tipo_carga: id_tipo_carga, cantidad: cantidad, id_tipo_categoria: id_tipo_categoria, id_usuario_area: id_usuario_area }, function() {}).done(function(resultado) {
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

                    if (estado == 'C') {
                        ruta = DIRECCION_WS + "../ticket/ticket_salida_puerta4.php";
                        openWindowWithPost(ruta, {
                            nro_placa: nro_placa,
                            estado: estado
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
    } else {

        var ruta = DIRECCION_WS + "salida.puerta4.agregar.pagar.php";

        var nro_placa = $("#modal_nro_placa").val()
        var id_salida = $('#modal_id_salida').val()
        var id_tipo_carga = $("#modal_tipo_carga").val()

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
            $.post(ruta, { nro_placa: nro_placa, id_salida: id_salida, id_tipo_carga: id_tipo_carga }, function() {}).done(function(resultado) {
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

                    ruta = DIRECCION_WS + "../ticket/ticket_salida_puerta4.php";
                    openWindowWithPost(ruta, {
                        nro_placa: nro_placa,
                        estado: estado
                    });
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

function listar() {

    var ruta = DIRECCION_WS + "salida.puerta4.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Nro Placa</th>';
            html += '<th>Nro Salida</th>';
            html += '<th>Estado</th>';
            html += '<th>Cantidad</th>';
            html += '<th>Tipo</th>';
            html += '<th>Precio</th>';
            html += '<th>SubTotal</th>';
            html += '<th>Fecha y Hora</th>';
            html += '<th>Usuario</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.nro_placa + '</td>';
                html += '<td>' + item.id_salida + '</td>';
                if (item.estado == "C") {
                    html += '<td><span class="badge2 label-table badge-danger"><i class="mdi mdi-arrow-down-thick"></i>CANCELADO</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-success"><i class="mdi mdi-arrow-up-thick"></i>PENDIENTE</span></td>';
                }
                html += '<td>' + item.cantidad + '</td>';
                if (item.nombre_carga == "NO SE COBRA") {
                    html += '<td>' + item.nombre_categoria + '</td>';
                    html += '<td>' + item.precio_categoria + '</td>';
                } else {
                    html += '<td>' + item.nombre_carga + '</td>';
                    html += '<td>' + item.precio_carga + '</td>';
                }
                html += '<td>' + item.sub_total + '</td>';
                html += '<td>' + item.fecha + ' - ' + item.hora + '</td>';
                html += '<td>' + item.nombre_usuario + '</td>';
                html += '<td class="text-center">';
                if (item.estado == "C") {
                    html += '<button type="button" hidden></button>';
                } else {
                    html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning" data-toggle="modal" data-target="#signup-modal" onclick="leerDatos(' +"'"+ item.nro_placa + "'," + item.id_salida + ')"> <i class="fa fa-wrench"></i> PAGAR </button>';
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
                    [2, "desc"]
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

function leerDatos(nro_placa, id_salida) {

    var ruta = DIRECCION_WS + "salida.puerta4.leerdatos.php";

    $.post(ruta, { nro_placa: nro_placa, id_salida: id_salida }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {
                $("#txttipooperacion").val("editar");

                $("#modal_id_salida").val(item.id_salida);

                $("#modal_nro_placa").val(item.nro_placa);
                $("#modal_nro_placa").attr('disabled', 'disabled');

                $("#modal_cobrar").val("P");
                $("#modal_cobrar").attr('disabled', 'disabled');

                $('#modal_cantidad').prop('required', false);
                $('#pendiente').show()
                $('#ahora').hide()

                $("#modal_tipo_carga").removeAttr('disabled');
                $("#modal_tipo_carga").val("").trigger('change');
                $("#modal_tipo_carga>option[value='1']").attr('disabled', 'disabled');

            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
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