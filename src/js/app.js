let paso = 1;
const pasoIncial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
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
  idCliente(); // Identifica el ID del cliente
  nombreCliente(); // Registra el nombre del cliente
  seleccionarFecha(); // Registra la fecha para la cita
  seleccionarHora(); // Registra la hora para la cita
  mostrarResumen(); // Mostrar el resumen de la cita
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

      if (paso === 3) {
        mostrarResumen();
      }
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
}

/* NOMBRE CLIENTE */
function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value; // Adjunta el nombre del cliente en el arreglo de la cita
}

/* ID CLIENTE */
function idCliente() {
  cita.id = document.querySelector("#id").value; // Adjunta el nombre del cliente en el arreglo de la cita
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
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];

    if (hora < 10 || hora > 19) {
      e.target.value = "";
      mostrarAlerta("Horario no válido", "error", ".formulario");
    } else {
      cita.hora = e.target.value;
    }
  });
}

/* MOSTRAR ALERTA */
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
  // Previene que se generen más de 1 alerta
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  // Scripting para crear la alerta
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta", tipo);

  // Animación de entrada (pequeño "grow")
  requestAnimationFrame(() => {
    alerta.classList.add("animar");
  });

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaparece) {
    // Eliminar la alerta
    setTimeout(() => {
      alerta.classList.remove("animar");
      alerta.classList.add("ocultar");
      setTimeout(() => {
        alerta.remove();
      }, 500);
    }, 3000);
  }
}

/* MOSTRAR RESUMEN */
function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  // Limpiar el Contenido de Resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Faltan datos de Servicios, Fecha u Hora",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  // Formatear el div de resumen
  const { nombre, fecha, hora, servicios } = cita; // 'hora' aquí está en formato "HH:MM" (ej: "14:30")

  // Heading para los servicio en resumen
  const headingServicios = document.createElement("H3");
  headingServicios.textContent = "Resumen de los servicios";
  resumen.appendChild(headingServicios);

  // Iterando y mostrando los servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    resumen.appendChild(contenedorServicio);
  });

  // Heading para los datos del cliente
  const headingCita = document.createElement("H3");
  headingCita.textContent = "Datos del cliente";
  resumen.appendChild(headingCita);

  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  // Formatear la fecha en español
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));
  const opcionesFecha = {
    // Renombrado para claridad
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaFormateada = fechaUTC.toLocaleDateString("es-VE", opcionesFecha); // Corregido 'opciones' a 'opcionesFecha'

  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

  // --- INICIO: Formateo de la Hora ---
  const [horas24, minutos] = hora.split(":"); // Separa horas y minutos (ej: "14", "30")
  let horas12 = parseInt(horas24, 10); // Convierte las horas a número
  const ampm = horas12 >= 12 ? "PM" : "AM"; // Determina si es AM o PM

  if (horas12 === 0) {
    // Caso de medianoche (00:xx)
    horas12 = 12;
  } else if (horas12 > 12) {
    // Caso de horas PM (13 en adelante)
    horas12 -= 12;
  }
  // Las horas de 1 a 11 AM no necesitan cambio numérico

  const horaFormateada = `${horas12}:${minutos} ${ampm}`; // Construye la hora formateada (ej: "2:30 PM")
  // --- FIN: Formateo de la Hora ---

  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora:</span> ${horaFormateada}`; // <<< Usa la hora formateada

  // Botón para crear una cita
  const botonReservar = document.createElement("BUTTON");
  botonReservar.classList.add("boton");
  botonReservar.textContent = "Reservar cita";
  botonReservar.onclick = reservarCita;

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita); // <<< Se añade el párrafo con la hora formateada
  resumen.append(botonReservar);
}

/* RESERVAR CITA */
async function reservarCita() {
  const { nombre, fecha, hora, servicios, id } = cita;
  const idServicios = servicios.map((servicio) => servicio.id);
  const datos = new FormData();

  datos.append("usuarioId", id);
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("servicios", idServicios);

  // Peticón hacia la API
  const url = "http://localhost:3000/api/citas";
  const respuesta = await fetch(url, {
    method: "POST",
    body: datos,
  });
  const resultado = await respuesta.json();

  console.log([...datos]);
}
