<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades'; // asegúrate de que la tabla exista
    protected $fillable = ['nombre', 'id_materia', 'numero_unidad', 'orden'];

    public function subtemas()
    {
        return $this->hasMany(Subtema::class, 'id_unidad');
    }
}
