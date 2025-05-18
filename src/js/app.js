let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: "",
    fecha: "",
    hora: "",
    servicios: []
}

document.addEventListener("DOMContentLoaded", function () {

    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); //Muestra la seccion que corresponde al paso
    tabs(); //Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones de siguiente y anterior
    paginaAnterior(); // Cambia la seccion al paso anterior
    paginaSiguiente(); // Cambia la seccion al siguiente paso

    consultarAPI(); //Consulta la API en el backend de PHP
    nombreCliente(); // Agrega el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita
    seleccionarHora(); // Añade la hora de la cita
    mostrarResumen(); // Muestra el resumen de la cita

}

function mostrarSeccion() {
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector(".mostrar");
    if(seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");
    }
    //Seleccionar la seccion que se va a mostrar
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add("mostrar");
    //Quita la clase actual al tab anterior
    const tabAnterior = document.querySelector(".tabs .actual");
    if(tabAnterior) {
        tabAnterior.classList.remove("actual");
    }
    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");

}

function tabs() {
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach(boton => {
        boton.addEventListener("click",function(e){
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const paginaSiguiente = document.querySelector("#siguiente");
    const paginaAnterior = document.querySelector("#anterior");
    if(paso === 1) {
        paginaAnterior.classList.add("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }else if(paso === 3) {
        paginaSiguiente.classList.add("ocultar");
        paginaAnterior.classList.remove("ocultar");
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector("#anterior");
    paginaAnterior.addEventListener("click", function() {
         if(paso < pasoInicial) return;
    paso--;
    botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector("#siguiente");
    paginaSiguiente.addEventListener("click", function() {
         if(paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
    });
}

async function consultarAPI(){
    try {
        const url = "http://localhost:3000/api/servicios";
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;
        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;
        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `${precio}€`;
        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector("#servicios").appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
     const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si el servicio ya fue añadido
    if(servicios.some(agregado => agregado.id === id)){
        //Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove("seleccionado");
    }else{
        //Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
    console.log(cita);
}

function nombreCliente() {
   cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector("#fecha");
    inputFecha.addEventListener("input", function(e) {
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes(dia)) {
            e.target.value = "";
            mostrarAlerta("Los fines de semana no están permitidos", "error",".formulario");
    }else{
        cita.fecha = e.target.value;
    }});
}

function seleccionarHora(){
    const inputHora = document.querySelector("#hora");
    inputHora.addEventListener("input", function(e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(":");
        if(hora[0] < 10 || hora[0] > 18) {
            e.target.value = "";
            mostrarAlerta("La hora no es válida", "error",".formulario");
        }else{
            cita.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo,elemento,desaparecer = true) {
    const alertaPrevia = document.querySelector(".alerta");
    if(alertaPrevia) {
        alertaPrevia.remove();
    }
    const alerta = document.createElement("DIV");
    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);
    if(desaparecer) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen() {
    const resumen = document.querySelector(".contenido-resumen");

    //Limpiar el contenido previo
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }
    if(Object.values(cita).includes("") || cita.servicios.length === 0) {
        mostrarAlerta("Faltan datos de la cita", "error", ".contenido-resumen",false);
        return
    }
    //Mostrar el resumen
    const { nombre, fecha, hora, servicios } = cita;
    const nombreCliente = document.createElement("P");
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
    const fechaCita = document.createElement("P");
    fechaCita.innerHTML = `<span>Fecha:</span> ${fecha}`;
    const horaCita = document.createElement("P");
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;
    
    servicios.forEach(servicio => {
        const { id,nombre, precio } = servicio;
        const servicioTexto = document.createElement("P");
        servicioTexto.innerHTML = `<span>Servicio:</span> ${nombre} - <span>Precio:</span> ${precio}€`;
        resumen.appendChild
        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");
        const textoServicio = document.createElement("P");
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.textContent = `${precio}€`;
        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    });

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

}