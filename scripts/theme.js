
document.addEventListener("DOMContentLoaded", () => {
  const html = document.documentElement;
  const toggle = document.getElementById("theme-toggle");
  const icon = document.getElementById("theme-icon");

  // Seguridad: si no existe el toggle (ej: en otras páginas) no ejecutamos el listener
  // (esto permite incluir el script con defer sin romper nada)
  if (!toggle) {
    // Si no hay toggle, igualmente aplicamos el theme guardado
    const saved = localStorage.getItem('theme');
    if (saved === 'light') {
      html.classList.add('light-mode');
      html.classList.remove('dark-mode');
    } else if (saved === 'dark') {
      html.classList.add('dark-mode');
      html.classList.remove('light-mode');
    }
    return;
  }

  // Inicializar icon + clases según lo guardado (si no hay guardado, por defecto 'dark')
  const saved = localStorage.getItem('theme');
  if (saved === 'light') {
    html.classList.add('light-mode');
    html.classList.remove('dark-mode');
    if (icon) { icon.classList.remove('fa-moon'); icon.classList.add('fa-sun'); }
  } else {
    html.classList.add('dark-mode');
    html.classList.remove('light-mode');
    if (icon) { icon.classList.remove('fa-sun'); icon.classList.add('fa-moon'); }
  }

  toggle.addEventListener('click', () => {
    // efecto
    html.classList.add('theme-transition');
    if (icon) {
      icon.style.transition = "transform 0.6s ease";
      icon.style.transform = "rotate(360deg)";
    }

    setTimeout(() => {
      const nowIsLight = html.classList.contains('light-mode');
      const newMode = nowIsLight ? 'dark' : 'light';

      if (newMode === 'light') {
        html.classList.add('light-mode');
        html.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
        if (icon) { icon.classList.remove('fa-moon'); icon.classList.add('fa-sun'); }
      } else {
        html.classList.add('dark-mode');
        html.classList.remove('light-mode');
        localStorage.setItem('theme', 'dark');
        if (icon) { icon.classList.remove('fa-sun'); icon.classList.add('fa-moon'); }
      }

      // limpiar transiciones
      setTimeout(() => {
        html.classList.remove('theme-transition');
        if (icon) icon.style.transform = "rotate(0deg)";
      }, 420);
    }, 150);
  });
});
