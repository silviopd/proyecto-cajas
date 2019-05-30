jQuery(document).ready(function($) {
    listar();
});


function listar() {

    var ruta = DIRECCION_WS + "personal.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Dni</th>';
            html += '<th>Nombres y Apellidos</th>';
            html += '<th>Tipo Personal</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.dni + '</td>';
                html += '<td>' + item.nombres_apellidos + '</td>';
                html += '<td>' + item.nombre_tipo_personal + '</td>';
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-info" data-toggle="modal" data-target="#signup-modal" onclick="marcar(' + formatNumero(item.dni,8) + ')"> <i class="mdi mdi-account-check"></i> MARCAR </button>';
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

function marcar(dni) {

    var ruta = DIRECCION_WS + "ingreso.puerta4.datos.personal.php";

    var dni, id_tipo_personal, precio, fecha_pagada, dias_pagar, sub_total, ultima_fecha, hoy_fecha, dias_mora, esta;

    $.post(ruta, { dni: formatNumero(dni, 8) }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {

            dni = datosJSON.datos.dni
            id_tipo_personal = datosJSON.datos.id_tipo_personal
            precio = datosJSON.datos.precio

            if (id_tipo_personal == 7) {
                fecha_pagada = datosJSON.datos.fecha_pagada
                dias_pagar = datosJSON.datos.dias_pagar
                sub_total = datosJSON.datos.sub_total
                total = sub_total + precio
            }else {
                total = precio
            }


            if (id_tipo_personal == 7) { /*CARRETILLERO*/
                swal({
                    title: '¿ASISTENCIA ' + dni + '?',
                    html: "     Pago por ingreso => " + parseFloat(precio).toFixed(2) + "<br>" +
                        "Precio por guardiania(" + fecha_pagada + ") => " + parseFloat(sub_total).toFixed(2) + "<br>" +
                        "         Precio total =>" + parseFloat(total).toFixed(2),
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-confirm mt-2',
                    cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                    confirmButtonText: 'registrar',
                    cancelButtonText: 'cancelar',
                    imageUrl: "../vista/imagenes/pregunta.png"
                }).then(function() {

                    var ruta = DIRECCION_WS + "ingreso.puerta4.agregar.carretillero.php";
                    var id_usuario = Cookies.get('id_usuario_area');

                    $.post(ruta, { dni: formatNumero(dni, 8), id_usuario: id_usuario }, function() {}).done(function(resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) {

                            swal({
                                title: 'EXITO!',
                                text: datosJSON.mensaje,type: 'success',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            });

                            ruta = DIRECCION_WS + "../ticket/ticket.php";
                            openWindowWithPost(ruta, {
                                dni: dni,
                                fecha_pagada: fecha_pagada
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
                swal({
                    title: '¿ASISTENCIA ' + dni + '?',
                    html: "     Pago por ingreso => " + parseFloat(precio).toFixed(2),
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-confirm mt-2',
                    cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                    confirmButtonText: 'registrar',
                    cancelButtonText: 'cancelar',
                    imageUrl: "../vista/imagenes/pregunta.png"
                }).then(function() {

                    var ruta = DIRECCION_WS + "ingreso.puerta4.agregar.otros.php";
                    var id_usuario = Cookies.get('id_usuario_area');

                    $.post(ruta, { dni: formatNumero(dni, 8), id_usuario: id_usuario }, function() {}).done(function(resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) {

                            swal({
                                title: 'EXITO!',
                                text: datosJSON.mensaje,
                                type: 'success',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            });

                            ruta = DIRECCION_WS + "../ticket/ticket.php";
                            openWindowWithPost(ruta, {
                                dni: dni
                            });
                        } else {
                            swal("Mensaje del sistema", resultado, "warning");
                        }
                    }).fail(function(error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    })
                })
            }


        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function formatNumero(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */
    var zero = "0"; /* String de cero */

    if (width <= length) {
        if (number < 0) {
            return ("-" + numberOutput.toString());
        } else {
            return numberOutput.toString();
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString());
        }
    }
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
