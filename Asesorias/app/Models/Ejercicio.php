<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';

    protected $fillable = [
        'nombre',
        'contenido',
        'id_eje_unidad'
    ];

    // Relación con EjeUnidad
    public function ejeUnidad()
    {
        return $this->belongsTo(EjeUnidad::class, 'id_eje_unidad');
    }
}
