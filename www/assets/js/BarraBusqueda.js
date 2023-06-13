$(document).ready(() => {

    console.log("AJAX ready");
    var barraBusqueda = document.getElementById("search");
    barraBusqueda.oninput = obtenerCoincidencias;

});

function obtenerCoincidencias() {

    var cadena = document.getElementById('search').value;

    console.log('Buscando por cadena: ' + cadena);

    if (cadena.length > 0) {

        $.ajax({
            data: {cadena},
            url: '__obtenerCoincidencias.php',
            type: 'get',
            beforeSend: () => {
                $("#resultadoBusqueda").show();
                $("#resultadoBusqueda > ul").html("<li>...</li>");
            },
            success: (response) => {
                mostrarCoincidencias(response);
                console.log(response);
            }
        });

    }
    else {
        $("#resultadoBusqueda").hide();
    }

}

function mostrarCoincidencias(response) {

    var num_coincidencias = response.length;

    if (num_coincidencias > 0) {

        htmlLista = "";
        for (var i = 0; i < num_coincidencias; i++) {
            htmlLista += "<li><a href=\'cientifico.php?id=" + response[i].id + "\'>" + response[i].nombre + "</a></li>\n";
        }
        $("#resultadoBusqueda > ul").html(htmlLista);

    }
    else {
        $("#resultadoBusqueda").hide();
    }

}