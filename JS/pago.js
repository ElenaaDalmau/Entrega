document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los botones con la clase 'metodo'
    const metodoButtons = document.querySelectorAll('.metodo button');
  
    metodoButtons.forEach(button => {
      button.addEventListener('click', function () {
        // Eliminar la clase 'active' de todos los botones
        metodoButtons.forEach(btn => btn.classList.remove('active'));
  
        // Agregar la clase 'active' solo al botón clicado
        this.classList.add('active');
      });
    });
  });
  