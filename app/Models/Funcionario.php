<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "funcionario";

    public function Almacen() {
        return $this -> belongsTo(Almacen::class);
    }

    public function Usuario() {
        return $this -> belongsTo(User::class);
    }
}
