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
  console.log("Mostrar sección");
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
