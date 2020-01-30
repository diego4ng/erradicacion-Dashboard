<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $connection = 'mysql2';
    protected $table = "c_dependencias";
}
