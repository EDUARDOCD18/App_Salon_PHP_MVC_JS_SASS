let paso = 1;
const pasoIncial = 1;
const pasoFinal = 3;

const cita = {
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

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
  nombreCliente(); // Registra el nombre del cliente
  seleccionarFecha(); // Registra la fecha para la cita
  seleccionarHora(); // Registra la hora para la cita
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
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    };

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}

/* SELECCIONAR EL SERVICIO */
function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`); // Identificar el elemento al que se le da click

  // Comprobar si un servicio ya ha sido seleccionado
  if (servicios.some((agregado) => agregado.id === id)) {
    // Eliminarno
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    // Agregarlo
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }

  console.log(cita);
}

/* NOMBRE CLIENTE */
function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value; // Adjunta el nombre del cliente en el arreglo de la cita
}

/* FECHA DE LA CITA */
function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", function (e) {
    const dia = new Date(e.target.value).getUTCDay();

    if ([6, 0].includes(dia)) {
      e.target.value = "";
      mostrarAlerta("Fines de semana no permitidos", "error", ".formulario");
    } else {
      cita.fecha = e.target.value;
    }
  });
}

/* HORA DE LA CITA */
function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", function (e) {
    console.log(e.target.value);

    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];

    if (hora < 10 || hora > 19) {
      e.target.value = "";
      mostrarAlerta("Horario no válido");
    } else {
      cita.hora = e.target.value;
    }
  });
}

/* MOSTRAR ALERTA */
function mostrarAlerta(mensaje, tipo) {
  // Previene que se genere más de una alera
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) return;

  // Crear la alerta
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add("error");

  const formulario = document.querySelector(".formulario");

  // Elimiar la alerta
  setTimeout(() => {
    alerta.remove();
  }, 3000);
  formulario.appendChild(alerta);
}
