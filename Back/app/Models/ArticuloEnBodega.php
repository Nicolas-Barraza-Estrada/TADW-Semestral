<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloEnBodega extends Model
{
    use HasFactory;
    protected $fillable = ['articulo_id', 'bodega_id', 'cantidadArticulo'];
    protected $table = 'articulos_en_bodegas';
}
