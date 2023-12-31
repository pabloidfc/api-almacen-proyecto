<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehiculo";

    public function Transportista() {
        return $this -> hasMany(Transportista::class);
    }

    public function VehiculoTransporta() {
        return $this -> hasMany(VehiculoTransporta::class, "vehiculo_id");
    }
}
