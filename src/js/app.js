let paso = 1;

document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

/* INICIAR APP  */
function iniciarApp() {
  tabs(); // Cambia de sección cuando se presionen los tabs
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
}

/* TABS */
function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);

      mostrarSeccion(); // Mostrar la sección
    });
  });
}
