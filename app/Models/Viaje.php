<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Viaje extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "viaje";

    public function Ruta() {
        return $this->belongsTo(Ruta::class);
    }

    public function ViajeAsignado() {
        return $this->hasMany(ViajeAsignado::class, "viaje_id");
    }
}
