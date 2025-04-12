let paso = 1;
const pasoIncial = 1;
const pasoFinal = 3;

document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

/* INICIAR APP  */
function iniciarApp() {
  mostrarSeccion(); // Muestra y oculta las secciones
  tabs(); // Cambia de sección cuando se presionen los tabs
  botonesPaginador(); // Agrega o quita los botones del paginador
  paginaAnterior(); // Moverse a tab anterior
  paginaSiguiente(); // Moverse al tab siguiente
  consultarAPI(); // Realiza consultas a la API en el backend de PHP
}

/* MOSTRAR LA SECCIÓN */
function mostrarSeccion() {
  // Mostrar la sección que tenga la clase de mostrar
  const seccionAnterior = document.querySelector(".mostrar");

  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  // Mostrar la sección con el paso
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar"); // Agregar la clase de mostrar

  // Quita la clase actual del tab anterior
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  // Resalta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

/* TABS */
function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);

      mostrarSeccion(); // Mostrar la sección
      botonesPaginador(); // Botones del paginador
    });
  });
}

/* BOTONES DEL PAGINADOR */
function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }

  mostrarSeccion();
}

/* PAGINA ANTERIOR */
function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    // Evaluar si el paso actual es menor al inicial
    if (paso <= pasoIncial) return;
    paso--;

    botonesPaginador();
  });
}

/* PAGINA SIGUIENTE */
function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", function () {
    // Evaluar si el paso actual es menor al inicial
    if (paso >= pasoFinal) return;
    paso++;

    botonesPaginador();
  });
}

/* CONSULTAR API */
async function consultarAPI() {
  try {
    const url = "http://localhost:3000/api/servicios"; // Consulta la bdd
    const resultado = await fetch(url); // Consulta la API
    const servicios = await resultado.json(); // Obtener los resultados

    mostarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

/* MOSTRAR LOS SERVICIO */
function mostarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    // Nombre del servicio
    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    // Precio del servicio
    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$ ${precio}`;

    // div para los servicios
    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}
