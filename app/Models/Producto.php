<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'id_producto',
        'nombre',
        'precio_unitario',
        'stock',
        'imagen',
        'id_categoria',
        'cod_estanteria',
        'cod_almacen',
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'id_categoria', 'id_categoria');
    }
}
