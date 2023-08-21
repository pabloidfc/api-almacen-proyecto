<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = "almacen";

    public function Productos() {
        return $this -> hasMany(Producto::class);
    }
}
