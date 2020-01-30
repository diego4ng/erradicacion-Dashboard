<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MetodoSiembra extends Model
{
    protected $connection = 'mysql2';
    protected $table = "c_msiembra";
}
