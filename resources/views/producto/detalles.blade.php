<div class="card">
    <div class="card-header">
        Detalles del producto
    </div>
    <div class="card-body">
        <h5 class="card-title text-lg font-semibold text-black">{{ $producto->nombre }}</h5>
        <p class="card-text text-gray-600">{{ $producto->precio_unitario }} €</p>
        <img src="{{ asset($producto->imagen) }}" alt="imagen" class="w-20 h-20">
        <p class="card-text">{{ $producto->descripcion }}</p>
    </div>
</div>
