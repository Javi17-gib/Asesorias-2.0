<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjeUnidad extends Model
{
    use HasFactory;

    protected $table = 'ejeunidades';
    protected $fillable = ['nombre', 'titulo', 'id_materia', 'numero_unidad', 'orden'];

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class, 'id_eje_unidad');
    }
    public function materia()
{
    return $this->belongsTo(Materia::class, 'id_materia');
}

}

