<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'codigo_materia',
        'id_users'
    ];

    public function docente()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    // Relación con Unidades
    public function unidades()
    {
        return $this->hasMany(Unidad::class, 'id_materia')->orderBy('orden');
    }
}
