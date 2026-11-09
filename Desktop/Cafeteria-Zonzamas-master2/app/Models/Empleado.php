<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    public $incrementing = false;

    protected $fillable = [
        'id_empleado',
        'fecha_contratacion',
        'puesto',
    ];

    protected $casts = [
        'fecha_contratacion' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_empleado', 'id');
    }
}
