<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "producto";

    public function Lote() {
        return $this -> belongsTo(Lote::class);
    }

    public function Almacen() {
        return $this -> belongsTo(Almacen::class);
    }
}