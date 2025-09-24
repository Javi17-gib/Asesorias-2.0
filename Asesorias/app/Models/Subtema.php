<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtema extends Model
{
    use HasFactory;

    protected $table = 'subtemas';
    protected $fillable = ['nombre', 'id_unidad', 'descripcion', 'orden'];

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad');
    }
}
