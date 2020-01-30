<?php

namespace App\Models\Admin;
use App\Models\Admin\Plantio;

use Illuminate\Database\Eloquent\Model;

class TipoPlantio extends Model
{
    protected $connection = 'mysql2';
    protected $table = "c_tplatios";
}
