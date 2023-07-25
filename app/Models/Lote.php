<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "lote";

    public function Productos() {
        return $this -> hasMany(Producto::class);
    } 
}
