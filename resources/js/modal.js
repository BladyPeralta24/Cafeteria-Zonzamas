document.addEventListener('DOMContentLoaded', function() {
    var openModalButtons = document.querySelectorAll('.open-modal');

    openModalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = button.getAttribute('data-id');

            var modal = document.getElementById('modal');
            modal.style.display = 'block';

            var modalContent = document.getElementById('modal-content');
            fetch('/producto/' + id)
                .then(function(response) { return response.text(); })
                .then(function(html) { modalContent.innerHTML = html; });
        });
    });

    var closeModalButton = document.getElementById('close-modal');

    closeModalButton.addEventListener('click', function() {
        var modal = document.getElementById('modal');
        modal.style.display = 'none';
    });
});
