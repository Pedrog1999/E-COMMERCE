document.addEventListener("DOMContentLoaded", () => {
  const html = document.documentElement;
  const toggle = document.getElementById("theme-toggle");
  const icon = document.getElementById("theme-icon");

  // Cargar tema guardado
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    html.classList.add("dark-mode");
    icon.classList.replace("fa-moon", "fa-sun");
  }

  toggle.addEventListener("click", () => {
    // Agrega efecto visual suave
    html.classList.add("theme-transition");

    // Rotación del ícono tipo "spin solar"
    icon.style.transition = "transform 0.6s ease";
    icon.style.transform = "rotate(360deg)";

    setTimeout(() => {
      const darkModeOn = html.classList.toggle("dark-mode");

      if (darkModeOn) {
        icon.classList.replace("fa-moon", "fa-sun");
        localStorage.setItem("theme", "dark");
      } else {
        icon.classList.replace("fa-sun", "fa-moon");
        localStorage.setItem("theme", "light");
      }

      // Quita el blur/fade y reinicia la rotación
      setTimeout(() => {
        html.classList.remove("theme-transition");
        icon.style.transform = "rotate(0deg)";
      }, 400);

    }, 150);
  });
});
const body = document.body;

document.querySelector('.theme-toggle').addEventListener('click', () => {
  body.classList.add('transitioning');
  setTimeout(() => body.classList.remove('transitioning'), 800);
});

