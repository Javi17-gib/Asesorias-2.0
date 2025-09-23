<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades'; // <-- aquí le dices la tabla correcta

    protected $fillable = ['nombre', 'id_materia', 'orden'];

    public function subtemas()
    {
        return $this->hasMany(Subtema::class, 'id_unidad');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }
}
