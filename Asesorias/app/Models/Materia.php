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
}
