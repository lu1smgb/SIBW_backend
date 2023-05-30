// Se encarga de censurar las palabras prohibidas
function censurarContenido(domContent) {

    // Las palabras prohibidas ahora se encuentran en la base de datos (tabla PalabraProhibida)
    // Podemos encontrar la declaración de la variable que las contiene en el fichero de la plantilla (cientifico.twig)

    // Obtenemos el contenido del comentario
    var content = domContent.value;
    const posCursor = domContent.selectionStart;

    // Reemplazamos las palabras prohibidas en el texto
    content = content.split(/\b/);
    for (let i=0; i < content.length; i++) {
        if (banned.includes(content[i])) {

            console.log(`Palabra prohibida detectada: ${content[i]}`);

            // Cambiamos todos los caracteres de la palabra por '*'
            content[i] = '*'.repeat(content[i].length);

            // Actualizamos el contenido del comentario
            domContent.value = content.join('');

            // Actualizamos la posición del cursor
            //? El cursor irá al final si no ponemos estas líneas
            domContent.selectionStart = posCursor;
            domContent.selectionEnd = posCursor;
        }
    }

}

function init() {

    const textarea = document.getElementById('textarea');
    textarea.addEventListener('input', 
    () => {
        censurarContenido(textarea);
    }
    );

}

init();