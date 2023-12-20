<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $fillable = ['nombreArticulo', 'presentacionArticulo'];
    // Relación con ArticulosEnBodega
    public function articulosEnBodegas()
    {
        return $this->hasMany(ArticuloEnBodega::class, 'articulo_id');
    }
}
