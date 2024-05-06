// Para el manejo de los modales en el archivo dashboard.blade.php
document.addEventListener('DOMContentLoaded', function() {
    // Encuentra todos los botones que abren el modal
    var openModalButtons = document.querySelectorAll('.open-modal');

    // Añade un evento click a cada botón
    openModalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtiene el ID del producto del atributo data-id del botón
            var id = button.getAttribute('data-id');

            // Abre el modal
            var modal = document.getElementById('modal');
            modal.style.display = 'block';

            // Carga los detalles del producto en el modal
            var modalContent = document.getElementById('modal-content');
            fetch('/producto/' + id)
                .then(function(response) { return response.text(); })
                .then(function(html) { modalContent.innerHTML = html; });
        });
    });

    // Encuentra el botón que cierra el modal
    var closeModalButton = document.getElementById('close-modal');

    // Añade un evento click al botón
    closeModalButton.addEventListener('click', function() {
        // Cierra el modal
        var modal = document.getElementById('modal');
        modal.style.display = 'none';
    });
});
