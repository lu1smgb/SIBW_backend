function aniadirFilaSociales(event) {
    event.preventDefault();

    const tablaSociales = document.getElementById('tablaSociales');

    var nuevaFila = document.createElement('li');

    var campoNombre = document.createElement('input');
    campoNombre.type = 'text';
    campoNombre.name = 'nombre-social[' + tablaSociales.children.length + ']';

    var campoEnlace = document.createElement('input');
    campoEnlace.type = 'url';
    campoEnlace.name = 'enlace-social[' + tablaSociales.children.length + ']';

    var botonEliminar = document.createElement('input');
    botonEliminar.type = 'button';
    botonEliminar.name = 'eliminar-social[' + tablaSociales.children.length + ']';
    botonEliminar.value = 'Eliminar';
    botonEliminar.addEventListener('click',
        (event) => eliminarFilaSocial(event, botonEliminar)
    );

    nuevaFila.appendChild(campoNombre);
    nuevaFila.appendChild(campoEnlace);
    nuevaFila.appendChild(botonEliminar);
    tablaSociales.appendChild(nuevaFila);
}

function aniadirFilaHashtags(event) {
    event.preventDefault();

    const tablaHashtags = document.getElementById('tablaHashtags');

    var nuevaFila = document.createElement('li');

    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'nombre-hashtag[' + tablaHashtags.children.length + ']';

    var botonEliminar = document.createElement('input');
    botonEliminar.type = 'button';
    botonEliminar.name = 'eliminar-hashtag';
    botonEliminar.value = 'Eliminar';
    botonEliminar.addEventListener('click',
        (event) => eliminarFilaHashtags(event, botonEliminar)
    );

    nuevaFila.appendChild(input);
    nuevaFila.appendChild(botonEliminar);
    tablaHashtags.appendChild(nuevaFila);
}

function aniadirFilaImagen(event) {
    event.preventDefault();

    const tablaImagenes = document.getElementById('tablaImagenes');

    var nuevaFila = document.createElement('li');

    var input = document.createElement('input');
    input.type = 'file';
    input.name = 'imagen-cientifico[' + tablaImagenes.children.length + ']';

    var campoPie = document.createElement('input');
    campoPie.type = 'text';
    campoPie.name = 'pie[' + tablaImagenes.children.length + ']';

    var botonEliminar = document.createElement('input');
    botonEliminar.type = 'button';
    botonEliminar.name = 'eliminar-imagen';
    botonEliminar.value = 'Eliminar';
    botonEliminar.addEventListener('click',
        (event) => eliminarFilaImagen(event, botonEliminar)
    );

    nuevaFila.appendChild(input);
    nuevaFila.appendChild(campoPie);
    nuevaFila.appendChild(botonEliminar);
    tablaImagenes.appendChild(nuevaFila);
}

function eliminarFilaSocial(event, elemento) {
    event.preventDefault();
    const lista = elemento.parentElement.parentElement;
    const item = elemento.parentElement;
    item.remove();

    const items = lista.getElementsByTagName('li');
    for (var i=0; i < items.length; i++) {
        var inputs = items[i].getElementsByTagName('input'); 
        var nuevoNombre = 'nombre-social[' + i + ']';
        var nuevoEnlace = 'enlace-social[' + i + ']';
        inputs[0].name = nuevoNombre;
        inputs[1].name = nuevoEnlace;
        if (i > 0) {
            inputs[2].name = 'eliminar-social[' + i + ']';
        }
    }
}

function eliminarFilaHashtags(event, elemento) {
    event.preventDefault();
    const lista = elemento.parentElement.parentElement;
    const item = elemento.parentElement;
    item.remove();

    const items = lista.getElementsByTagName('li');
    for (var i=0; i < items.length; i++) {
        var inputs = items[i].getElementsByTagName('input'); 
        var nuevoNombreHashtag = 'nombre-hashtag[' + i + ']';
        inputs[0].name = nuevoNombreHashtag;
    }
}

function eliminarFilaImagen(event, elemento) {
    event.preventDefault();
    const lista = elemento.parentElement.parentElement;
    const item = elemento.parentElement;
    item.remove();

    const items = lista.getElementsByTagName('li');
    for (var i=0; i < items.length; i++) {
        var inputs = items[i].getElementsByTagName('input');
        var nuevoNombreImagen = 'imagen-cientifico[' + i + ']';
        var nuevoNombrePie = 'pie[' + i + ']'; 
        inputs[0].name = nuevoNombreImagen;
        inputs[1].name = nuevoNombrePie;
    }
}

function init() {

    document.getElementById('haFallecido').addEventListener('click',
        (event) => {
            const fechaDefuncion = document.getElementById('fechaDefuncion');
            if (fechaDefuncion.style.display == 'none') {
                fechaDefuncion.style.display = 'inline-flex';
            }
            else {
                fechaDefuncion.style.display = 'none';
            }
        }
    );

    document.getElementById('aniadirSocial').addEventListener('click',
        (event) => { aniadirFilaSociales(event); }
    );

    document.getElementById('aniadirHashtag').addEventListener('click',
        (event) => { aniadirFilaHashtags(event); }
    );

    document.getElementById('aniadirImagen').addEventListener('click',
        (event) => { aniadirFilaImagen(event); }
    );

}

init();