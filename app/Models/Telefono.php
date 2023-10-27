<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefono extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "telefono";

    public function Usuario() {
        return $this -> belongsTo(User::class);
    }
}
