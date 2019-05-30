$("#frmgrabar").submit(function(evento) {
    evento.preventDefault();

    $(".pre-loader").fadeIn("slow");

    var usuario = $("#txtusuario").val()
    var password = $("#txtpassword").val()

    var ruta = DIRECCION_WS + "sesion.validar.web.php";

    $.post(ruta, { usuario: usuario, password: password }, function() {}).done(function(resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            $(".pre-loader").fadeOut("slow");

            Cookies.set('nombre_usuario', datosJSON.datos[0].nombre_usuario);
            Cookies.set('id_usuario_area', datosJSON.datos[0].id_usuario_area);
            Cookies.set('token', datosJSON.mensaje);

            location.href = "./index.html"

            var acceso = [];

            $.each(datosJSON.datos, function(i, item) {
                acceso.push(item.id_modulo);
            });

            Cookies.set('acceso', acceso)

        } else {
            $(".pre-loader").fadeOut("slow");

            swal("Mensaje del sistema", "Datos Incorrectos", "warning");
        }
    }).fail(function(error) {
        $(".pre-loader").fadeOut("slow");
        swal("Mensaje del sistema", "Datos Incorrectos", "warning");
    })
});