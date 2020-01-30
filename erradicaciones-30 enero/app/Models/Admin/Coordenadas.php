<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Coordenadas extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_coordenadas";
}
