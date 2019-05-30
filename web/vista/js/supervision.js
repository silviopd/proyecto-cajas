jQuery(document).ready(function($) {
    listar();
});


function listar() {

    var ruta = DIRECCION_WS + "supervision.listar.php";

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
            html += '<th>ESTADO</th>';
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
                if (item.estado == 'P') {
                    html += '<td>PENDIENTE</td>';
                    html += '<td class="text-center">';
                    html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-success" onclick=trabajo(' + item.id_supervision_vfr + ')> <i class="fa fa-check"></i> </button>';
                    html += '&nbsp;'
                    html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-danger" onclick=no_trabajo(' + item.id_supervision_vfr + ')> <i class="fa fa-remove"></i> </button>';
                    html += '</td>';
                } else if (item.estado == 'N') {
                    html += '<td>NO TRABAJO</td>';
                    html += '<td></td>';
                } else {
                    html += '<td>TRABAJO</td>';
                    html += '<td></td>';
                }
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

/*
function trabajo(id_supervision_vfr) {
    var ruta = DIRECCION_WS + "supervision.trabajo.php";

    swal({
        title: '¿EL USUARIO TRABAJÓ?',
        text: "se cambiará el estado a trabajó!",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-confirm mt-2',
        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
        confirmButtonText: 'registrar',
        cancelButtonText: 'cancelar',
        imageUrl: "../vista/imagenes/pregunta.png"
    }).then(function() {
        $.post(ruta, { id_supervision_vfr: id_supervision_vfr }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
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

function no_trabajo(id_supervision_vfr) {
    var ruta = DIRECCION_WS + "supervision.no.trabajo.php";

    swal({
        title: '¿EL USUARIO TRABAJÓ?',
        text: "se cambiará el estado a trabajó!",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-confirm mt-2',
        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
        confirmButtonText: 'registrar',
        cancelButtonText: 'cancelar',
        imageUrl: "../vista/imagenes/pregunta.png"
    }).then(function() {
        $.post(ruta, { id_supervision_vfr: id_supervision_vfr }, function() {}).done(function(resultado) {
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
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
*/