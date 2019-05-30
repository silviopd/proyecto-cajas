(function($) {
    'use strict';
    $(window).on('load', function() {
        if ($(".pre-loader").length > 0) {
            $(".pre-loader").fadeOut("slow");
        }
    });
})(jQuery)

//var DIRECCION_WS = "http://localhost:8080/ecomphisa/webservices/webservice/";

var DIRECCION_WS = "https://ws.ecomphisa.com/webservice/"

menu()

jQuery(document).ready(function($) {

    if (Cookies.get('token') == null) {
        location.href = "./login.html"
    } else {
        document.getElementById("hud_nombre_usuario").textContent = Cookies.get('nombre_usuario');

        var menus = ["1", "2", "3", "4", "5", "6", "7"]
        var acceso = Cookies.get('acceso')
        var header = "";

        for (var i = 0; i < menus.length; i++) {
            for (var j = 0; j < acceso.length; j++) {
                if (menus[i] == acceso[j]) {
                    header = "menu" + acceso[j]
                    document.getElementById(header).children[0].style.display = "block"
                }
            }
        }
    }

});

$('#btnSalir').on("click", function() {

    Cookies.remove('nombre_usuario');
    Cookies.remove('token');
    Cookies.remove('acceso');
    Cookies.remove('id_usuario_area');

    location.href = "./index.html"
})

function menu() {
    document.getElementById("menu1").children[0].style.display = "none"
    document.getElementById("menu2").children[0].style.display = "none"
    document.getElementById("menu3").children[0].style.display = "none"
    document.getElementById("menu4").children[0].style.display = "none"
    document.getElementById("menu5").children[0].style.display = "none"
    document.getElementById("menu6").children[0].style.display = "none"
    document.getElementById("menu7").children[0].style.display = "none"
}