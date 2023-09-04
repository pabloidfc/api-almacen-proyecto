<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "almacen";

    public function Productos() {
        return $this -> hasMany(Producto::class);
    }

    public function Lotes() {
        return $this -> hasMany(Lote::class, "almacen_destino");
    }

    // TODO: Relacion con tabla Direcciones
}
