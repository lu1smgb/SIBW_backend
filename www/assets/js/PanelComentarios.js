/*
    JavaScript para la sección de comentarios

    Prácticas de SIBW
    Curso 2022/23
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    @lu1smgb on GitHub
*/

// Alterna la visibilidad del panel de comentarios
function cambiarEstadoPanelComentarios() {
    const panel = document.getElementById("panel-comentarios");
    var displayValue = panel.style.display;
    panel.style.display = (displayValue == "flex")? "none" : "flex";
}

// Devuelve los datos del formulario, pueden usarse en la función `agregarComentario`
function datosFormulario() {
    const form = document.querySelector("#panel-comentarios>#form-comentarios");
    const nombreEmail = form.querySelector("#nombre-email").getElementsByTagName("input");
    return {
        nombre: nombreEmail[0].value,
        email: nombreEmail[1].value,
        content: form.getElementsByTagName("textarea")[0].value
    };
}

// Limpia el contenido del formulario de los comentarios
function limpiarFormulario() {
    const form = document.querySelector("#panel-comentarios>#form-comentarios");
    const nombreEmail = form.querySelector("#nombre-email").getElementsByTagName("input");
    // Vaciamos los 3 campos
    nombreEmail[0].value = 
    nombreEmail[1].value = 
    form.getElementsByTagName("textarea")[0].value = "";
}

// Devuelve el número de comentarios
function contarComentarios() {
    const comentarios = document.getElementById("vista-comentarios");
    const cuenta = comentarios.getElementsByClassName("comentario").length;
    return cuenta;
}

// Actualiza los contadores de comentarios
function actualizarContador() {
    const contador = document.getElementById("contador-comentarios");
    var texto = contador.innerHTML.split(' ');
    texto[0] = contarComentarios();
    contador.innerHTML = texto.join(' ');
}

// Se encarga de censurar las palabras prohibidas
function censurarContenido() {

    // Array con las palabras prohibidas (son ligeras)
    const banned = [
        'tonto',
        'tonta',
        'recorcholis',
        'caracoles',
        'flautas',
        'repampanos',
        'cielos',
        'cipote',
        'cipota',
        'fifa'
    ];

    // Obtenemos el contenido del comentario
    const domContent = document.querySelector("#form-comentarios")
                               .getElementsByTagName("textarea")[0];
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

// Agrega un comentario a la lista de comentarios
function agregarComentario(comm) {

    // Expresión regular para detectar correos electrónicos válidos
    // https://www.w3resource.com/javascript/form/email-validation.php
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    // --- Excepciones --------------------------------------------------------

    // Si no se ha introducido nombre, saltará un error
    if (comm.nombre.length == 0) {
        throw new Error("\nEl campo del nombre está vacío (8 caracteres mínimo)")
    }

    // Si el email introducido no es válido
    if (!emailRegex.test(comm.email)) {
        throw new Error("\nEl email introducido no es válido");
    }

    // Si no hay nada en el contenido del comentario
    if (comm.content.length == 0) {
        throw new Error("\nEl comentario está vacío");
    }

    // ------------------------------------------------------------------------

    // Si todo va bien, construimos el elemento HTML para guardar el comentario

    // Inicializamos el nuevo comentario
    var nuevoComentario = document.createElement("div");
    nuevoComentario.className = "comentario";

    // Obtenemos el nombre
    var domNombre = document.createElement("strong");
    domNombre.className = "nombre";
    domNombre.innerHTML = comm.nombre;
    nuevoComentario.appendChild(domNombre);

    // Obtenemos la fecha (DD/MM/AAAA HH:MM)
    var domDate = document.createElement("strong");
    var date = new Date();
    domDate.className = "fecha";
    domDate.innerHTML = date.toLocaleDateString("es-ES",
                        {
                            day: "2-digit",
                            month: "2-digit",
                            year: "numeric"
                        })
                        + " - " +
                        date.toLocaleTimeString("es-ES",{
                            hours: "2-digit",
                            minutes: "2-digit",
                            seconds: "none"
                        });
    nuevoComentario.appendChild(domDate);
    
    // Obtenemos el contenido
    var domContent = document.createElement("p");
    domContent.className = "texto";
    domContent.innerHTML = comm.content;
    nuevoComentario.appendChild(domContent);

    // Lo añadimos al resto de comentarios
    var listaComentarios = document.getElementById("vista-comentarios");
    listaComentarios.appendChild(nuevoComentario);

}

// Función ejecutada por el botón de enviar comentario
// Indica si el comentario del formulario se ha publicado correctamente
function publicarComentario() {

    // Probamos a agregar el comentario con los datos del formulario
    try {
        agregarComentario(datosFormulario());
    }
    // Si ocurre algún error, notificamos al usuario y paramos
    catch (error) {
        window.alert(error);
        return false;
    }

    // Actualizamos el contador
    actualizarContador();

    // Limpiamos el formulario
    limpiarFormulario();

    // Y avisamos al usuario
    window.alert("Tu comentario se ha publicado correctamente");

    return true;

}

// Ejecutada al cargar la página
// Damos funcionalidad al botón de comentarios, al campo de texto del formulario y al botón de publicar
function init() {

    // Actualizamos el contador de comentarios
    actualizarContador();

    // Botón de comentarios (despliega y oculta el panel)
    const botonComentarios = document.getElementById("boton-comentarios");
    botonComentarios.addEventListener("click", cambiarEstadoPanelComentarios);

    // Campo de contenido del formulario de los comentarios
    const formComentarios = document.getElementById("form-comentarios");
    const textbox = formComentarios.getElementsByTagName("textarea")[0];
    textbox.addEventListener("input", censurarContenido);

    // Botón de publicar comentario
    const botonEnviar = formComentarios.getElementsByTagName("button")[0];
    botonEnviar.addEventListener("click", publicarComentario);

}

init();