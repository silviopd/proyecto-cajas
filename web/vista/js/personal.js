jQuery(document).ready(function($) {
    listar();
    select_tipo_personal()
});

$("#btnAgregar").click(function(event) {
    $("#txttipooperacion").val("agregar");
    $("#modal_dni").val("")
    $("#modal_nombres").val("")
    $("#modal_nro_carretilla").val("")
    $("#modal_tipo_personal").val("").trigger('change');
    $("#modal_estado").val("H")
    $("#modal_titulo").text("nuevo personal");
    $("#modal_nro_carretilla").prop('disabled', true);

    $("#modal_dni").prop("disabled", false);
});

function select_tipo_personal() {
    var ruta = DIRECCION_WS + "tipo.personal.autocompletar.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_tipo_personal">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_tipo_personal + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_tipo_personal").html(html);

            $("#modal_tipo_personal").select2({
                dropdownParent: $("#signup-modal")
            }).on('change', function(event) {
                event.preventDefault();

                if ($("#modal_tipo_personal").val() == 7) {
                    $("#modal_nro_carretilla").val("")
                    $("#modal_nro_carretilla").prop('disabled', false);
                } else {
                    $("#modal_nro_carretilla").val("")
                    $("#modal_nro_carretilla").prop('disabled', true);
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
            html += '<th>Nro</th>';
            html += '<th>Estado</th>';
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
                if (item.nro_carretilla == null) {
                    html += '<td></td>';
                } else {
                    html += '<td>' + item.nro_carretilla + '</td>';
                }
                if (item.estado === 'H') {
                    html += '<td><span class="badge2 label-table badge-success">Habilitado</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger">Inhabilitado</span></td>';
                }
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning" data-toggle="modal" data-target="#signup-modal" onclick="leerDatos(' +  zfill(item.dni,8) + ')"> <i class="fa fa-wrench"></i> </button>';
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

        var ruta = DIRECCION_WS + "personal.agregar.php";

        var dni = $("#modal_dni").val()
        var nombres_apellidos = $("#modal_nombres").val()
        var id_tipo_personal = $("#modal_tipo_personal").val()
        var estado = $("#modal_estado").val()
        var nro_carretilla = $("#modal_nro_carretilla").val()

        swal({
            title: '¿Desea Registrar?',
            text: "se agregará un nuevo personal!",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'registrar',
            cancelButtonText: 'cancelar',
            imageUrl: "../vista/imagenes/pregunta.png"
        }).then(function() {
            $.post(ruta, { dni: dni, nombres_apellidos: nombres_apellidos, nro_carretilla: nro_carretilla, id_tipo_personal: id_tipo_personal, estado: estado }, function() {}).done(function(resultado) {
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
        });

    } else {
        var ruta = DIRECCION_WS + "personal.editar.php";

        var dni = $("#modal_dni").val()
        var nombres_apellidos = $("#modal_nombres").val()
        var id_tipo_personal = $("#modal_tipo_personal").val()
        var estado = $("#modal_estado").val()
        var nro_carretilla = $("#modal_nro_carretilla").val()

        swal({
            title: '¿Desea Modificar?',
            text: "se modificará el personal",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'registrar',
            cancelButtonText: 'cancelar',
            imageUrl: "../vista/imagenes/pregunta2_1.png"
        }).then(function() {
            $.post(ruta, { dni: dni, nombres_apellidos: nombres_apellidos, nro_carretilla: nro_carretilla, id_tipo_personal: id_tipo_personal, estado: estado }, function() {}).done(function(resultado) {
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
        });


    }

});

function leerDatos(dni) {

    dni = zfill(dni,8);
    //alert(dni)

    var ruta = DIRECCION_WS + "personal.leerdatos.php";

    $.post(ruta, { dni: dni }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {
                $("#txttipooperacion").val("editar");

                $("#modal_dni").val(item.dni);
                $("#modal_nombres").val(item.nombres_apellidos);
                $("#modal_tipo_personal").val(item.id_tipo_personal).trigger('change');
                $("#modal_estado").val(item.estado);
                $("#modal_nro_carretilla").val(item.nro_carretilla);

                $("#modal_titulo").text("Editar personal");

                $("#modal_dni").prop("disabled", true);
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}

function zfill(number, width) {
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