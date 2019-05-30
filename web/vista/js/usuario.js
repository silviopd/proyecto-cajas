jQuery(document).ready(function($) {
    select_colaborador()
    listar()
});

function select_colaborador() {
    var ruta = DIRECCION_WS + "colaborador.autocompletar.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_colaborador">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.dni + '">' + item.nombre + '</option>';
            });

            html += '</select>';

            $("#modal_select_colaborador").html(html);

            $("#modal_colaborador").select2({
                dropdownParent: $("#signup-modal")
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
    $("#modal_colaborador").val("").trigger('change');
    $("#modal_pass").val("")
    $("#modal_pass2").val("")
    $("#modal_estado").val("H")
    $("#modal_titulo").text("nuevo colaborador");

    $("#modal_colaborador").prop("disabled", false);
});

function listar() {

    var ruta = DIRECCION_WS + "usuario.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Dni</th>';
            html += '<th>Nombre Completo</th>';
            html += '<th>Estado</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_usuario + '</td>';
                html += '<td>' + item.nombres + ' ' + item.apellidos + '</td>';
                if (item.estado === 'H') {
                    html += '<td><span class="badge2 label-table badge-success">Habilitado</span></td>';
                } else {
                    html += '<td><span class="badge2 label-table badge-danger">Inhabilitado</span></td>';
                }
                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-warning" data-toggle="modal" data-target="#signup-modal" onclick="leerDatos(' + item.id_usuario + ')"> <i class="fa fa-wrench"></i> </button>';
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

    if ($('#frmgrabar').parsley().validate()) {
        if ($("#txttipooperacion").val() == "agregar") {

            var ruta = DIRECCION_WS + "usuario.agregar.php";

            var id_usuario = $("#modal_colaborador").val()
            var pass = $("#modal_pass").val()
            var estado = $("#modal_estado").val()

            swal({
                title: '¿Desea Registrar?',
                text: "se agregará un nuevo usuario!",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'registrar',
                cancelButtonText: 'cancelar',
                imageUrl: "../vista/imagenes/pregunta.png"
            }).then(function() {
                $.post(ruta, { id_usuario: id_usuario, pass: pass, estado: estado }, function() {}).done(function(resultado) {
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
            var ruta = DIRECCION_WS + "usuario.editar.php";

            var id_usuario = $("#modal_colaborador").val()
            var pass = $("#modal_pass").val()
            var estado = $("#modal_estado").val()

            swal({
                title: '¿Desea Modificar?',
                text: "se modificará el usuario ",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'registrar',
                cancelButtonText: 'cancelar',
                imageUrl: "../vista/imagenes/pregunta2_1.png"
            }).then(function() {
                $.post(ruta, { id_usuario: id_usuario, pass: pass, estado: estado }, function() {}).done(function(resultado) {
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
    } else {
        swal("Error","Datos Incorrecto","error")
    }
});

function leerDatos(id_usuario) {

    var ruta = DIRECCION_WS + "usuario.leerdatos.php";

    $.post(ruta, { id_usuario: id_usuario }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $.each(datosJSON.datos, function(i, item) {
                $("#txttipooperacion").val("editar");

                $("#modal_colaborador").val(item.id_usuario).trigger('change');
                $("#modal_estado").val(item.estado);
                $("#modal_pass").val("");
                $("#modal_pass2").val("");

                $("#modal_titulo").text("Editar Usuario");

                $("#modal_colaborador").prop("disabled", true);
            });
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function(error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    })
}