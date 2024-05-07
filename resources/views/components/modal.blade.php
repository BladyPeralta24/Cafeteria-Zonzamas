<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="productModalLabel">Nombre del producto</h5>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <img id="productImage" src="" alt="imagen" class="product-image mr-3">
                <div class="text-center">
                    <p id="productDescription" class="h4">Descripción del producto</p>
                    <p id="productPrice" class="h4">Precio del producto</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cerrar btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="reservarButton" class="btn-reservar btn btn-success" {{-- data-id_producto="{{$producto->id_producto}}" --}} data-cantidad="1">Reservar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.view-details').on('click', function() {
        var name = $(this).data('name');
        var description = $(this).data('description');
        var price = $(this).data('price');
        var image = $(this).data('image');

        $('#productModalLabel').text(name);
        $('#productDescription').text(description);
        $('#productPrice').text(price + ' €');
        $('#productImage').attr('src', image);
    });
});
</script>


<script>
    $(document).ready(function() {
        // Evento para el botón de reservar
        $('#reservarButton').on('click', function() {
            var id_producto = $(this).data('id_producto'); // obtén el ID del producto
            var cantidad = $(this).data('cantidad'); // obtén la cantidad
            var id_user = '{{ Auth::user()->id }}'; // obtén el ID del usuario autenticado

            fetch('../cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_producto: id_producto,
                    cantidad: cantidad,
                    id_user: id_user
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data);
                } else {
                    console.log(data.message);// muestra el mensaje de error
                }
            });
        });
    });
</script>




<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal.fade .modal-dialog{
        transform: translate(0, -100%, 0);
        transition: transform 0.3s ease;
    }

    .modal.show .modal-dialog{
        transform: translate(0, 0, 0);
    }

    .product-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }

    .modal-body {
        font-size: 1.5rem;
    }

    .modal-header{
        display: flex;
        justify-content: center;
    }

    .modal-title{
        font-size: 2rem;
    }

    .btn-cerrar{
        border: 1px solid black;
        margin-right: 10px;
        font-size: 25px;
        color: black;
        background-color: rgba(207, 37, 37, 0.947);
    }

    .btn-reservar{
        border: 1px solid black;
        margin-left: 10px;
        font-size: 25px;
        color: white;
        background-color: rgb(72, 230, 48);
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

