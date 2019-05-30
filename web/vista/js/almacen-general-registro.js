jQuery(document).ready(function() {
    listar();
    $("#modal_id_usuario").val("1")
    select_area()
    $("#modal_stock").text(0);
});

function select_area() {
    var ruta = DIRECCION_WS + "area.autocompletar.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<select class="form-control input-sm" id="modal_area">';
            html += '<option value="" selected disabled>-- seleccione --</option>';
            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<option value="' + item.id_area + '">' + item.nombre + '</option>';
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

function listar() {

    var ruta = DIRECCION_WS + "producto.almacen.general.listar.php";

    $.post(ruta, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>N°</th>';
            html += '<th>Nombre</th>';
            html += '<th>STOCK</th>';
            html += '<th>UNIDAD MEDIDA</th>';
            html += '<th>CANTIDAD</th>';
            html += '<th class="text-center">Opciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i, item) {
                html += '<tr>';
                html += '<td>' + item.id_producto + '</td>';
                html += '<td id="producto_nombre' + item.id_producto + '">' + item.nombre + '</td>';
                html += '<td id="producto_stock' + item.id_producto + '">' + item.stock + '</td>';
                html += '<td>' + item.unidad_medida + '</td>';
                html += '<td><input class="form-control" type="text" id="modal_cantidad' + item.id_producto + '" placeholder=""></td>';

                html += '<td class="text-center">';
                html += '<button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-success" data-toggle="modal" data-target="#signup-modal-ingreso" onclick="agregarTabla(' + item.id_producto + ')"> <i class="fa fa-cloud-upload"></i> </button>';
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

function agregarTabla(id_prod) {

    var parametro = "#modal_cantidad" + id_prod
    var producto2 = "producto_nombre" + id_prod
    var stock2 = "producto_stock" + id_prod

    var cantidad = $(parametro).val()
    $(parametro).val("")

    var producto = document.getElementById(producto2).innerHTML
    var stock = document.getElementById(stock2).innerHTML

    // alert(stock)

    /*
    if (parseInt(cantidad) > parseInt(stock)) {
        swal("Verifique", "Cantidad pasa el stock", "warning");
        $("#txtcantidad").focus();
        return 0;
    }
    */

    //fila para llenar la tabla html en js
    var fila = '<tr>' +
        '<td class="text-center" type="hidden" style="vertical-align:middle;">' + id_prod + '</td>' +
        '<td class="text-center" style="font-size: 15px; style="vertical-align:middle;">' + producto + '</td>' +
        '<td class="text-center" style="font-size: 15px; class="text-right" style="vertical-align:middle;">' + cantidad + '</td>' +
        '<td id="celiminar" class="text-center" style="font-size:20px" ><a href="javascript:void()"><i class="fa fa-close text-danger"></i></a></td>' +
        '</tr>';

    //Validacion
    var a = 'no';
    $("#detalleventa tr").each(function() {
        var codigotabla = $(this).find("td").eq(0).html();
        if (id_prod == codigotabla) {
            a = 'si';
        };
    });

    if (a == 'si') {
        swal("Verifique", "Ya se encuentra agregado el Producto \n" + producto, "warning");
        $("#txtcodigoarticulo").val("");
        $("#txtarticulo").val("");
        $("#txtprecio").val("");
        $("#txtcantidad").val("");
        $("#txtstock").val("");

        $("#txtarticulo").focus();
        return 0;
    }

    //agregar
    $("#detalleventa").append(fila);
    //calcularTotales();
};
//ELIMINAR
$(document).on("click", "#celiminar", function() {
    var filaEliminar = $(this).parents().get(0);

    swal({
        title: "Confirme",
        text: "¿Desea eliminar el registro seleccionado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#ff0000',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: true
    }).then(function() {
        filaEliminar.remove();
    });

});


$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();
    // alert($("#frmgrabar").serialize());
    var arrayDetalle = new Array();
    var contacto = $("#modal_contacto").val()
    var id_area = $("#modal_area").val()
    var observacion = $("#modal_observacion").val()
    var operacion = $("#modal_operacion").val()
    var id_usuario_area = Cookies.get('id_usuario_area');

    swal({
        title: '¿Realizar registro?',
        text: "formato para requerimiento de materiales!",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-confirm mt-2',
        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
        confirmButtonText: 'registrar',
        cancelButtonText: 'cancelar',
        imageUrl: "../vista/imagenes/pregunta.png"
    }).then(function() {
        /*limpiar el array*/
        arrayDetalle.splice(0, arrayDetalle.length);
        /*limpiar el array*/

        /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
        $("#detalleventa tr").each(function() {
            var codigoArticulo = $(this).find("td").eq(0).html();
            var cantidad = $(this).find("td").eq(2).html();

            var objDetalle = new Object(); //Crear un objeto para almacenar los datos

            /*declaramos y asignamos los valores a los atributos*/
            objDetalle.codigoArticulo = codigoArticulo;
            objDetalle.cantidad = cantidad;
            /*declaramos y asignamos los valores a los atributos*/
            arrayDetalle.push(objDetalle); //agregar el objeto objDetalle al array arrayDetalle

        });

        /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/

        //Convertimos el array "arrayDetalle" a formato de JSON
        var jsonDetalle = JSON.stringify(arrayDetalle);

        // alert(jsonDetalle);
        //                    return 0;


        /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
        var ruta = DIRECCION_WS + "registro.almacen.agregar2.php";
        // alert(ruta);
        $.post(ruta, {
            p_contacto: contacto,
            p_id_area: id_area,
            p_observacion: observacion,
            p_operacion: operacion,
            p_id_usuario_area: id_usuario_area,
            p_datosJSONDetalle: jsonDetalle
        }).done(function(resultado) {
            var datosJSON = resultado;

            if (datosJSON.estado === 200) {
                swal({
                    title: 'EXITO!',
                    text: datosJSON.mensaje,
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });

                listar()

                $("#modal_contacto").val("")
                $("#modal_area").val("").trigger('change');
                $("#modal_observacion").val("")
                $("#modal_operacion").val("S")
                $("#detalleventa").empty();

                var ruta = DIRECCION_WS + "../reportes/reporte.almacen.general.registro.php";

                $.post(ruta, function() {}).done(function() {

                    window.open(DIRECCION_WS + "../reportes/reporte-almacen-general.pdf")

                }).fail(function(error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Error", datosJSON.mensaje, "error");
                })
            } else {
                swal("Mensaje del sistema", resultado, "warning");
            }
        }).fail(function(error) {
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        })
    });

});