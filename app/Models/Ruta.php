<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ruta";

    public function Viaje() {
        return $this -> hasMany(Viaje::class);
    }
}
