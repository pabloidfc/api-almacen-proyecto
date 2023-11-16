<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViajeAsignado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "viaje_asignado";

    protected $fillable = [
        "vehiculo_id",
        "lote_id",
        "viaje_id"
    ];

    public function Lote() {
        return $this -> belongsTo(Lote::class, "lote_id");
    } 

    public function Vehiculo() {
        return $this -> belongsTo(Vehiculo::class, "vehiculo_id");
    } 

    public function Viaje() {
        return $this->belongsTo(Viaje::class, "viaje_id");
    }
}
