document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        const checkbox = document.getElementById('terminos');
        if (!checkbox.checked) {
            alert('Debes aceptar los términos de la página antes de continuar.');
            event.preventDefault(); // Evita el envío del formulario
        }
    });
});
