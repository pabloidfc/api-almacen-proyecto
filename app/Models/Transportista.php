<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transportista extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "transportista";

    public function Usuario() {
        return $this -> belongsTo(User::class);
    }

    public function Vehiculo() {
        return $this -> belongsTo(Vehiculo::class);
    }
}
