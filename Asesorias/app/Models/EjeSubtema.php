<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjeSubtema extends Model
{
    use HasFactory;

    protected $table = 'ejesubtemas';
    protected $fillable = ['id_unidad', 'nombre', 'descripcion'];

    public function contenidos()
{
    return $this->hasMany(Contenido::class, 'id_subtema');
}
public function unidad()
{
    return $this->belongsTo(EjeUnidad::class, 'id_unidad');
}

}
