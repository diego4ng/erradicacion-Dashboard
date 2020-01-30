<?php

namespace App\Models\Admin;
use App\Models\Admin\Estado;
use App\Models\Admin\Municipio;
use App\Models\Admin\Localidad;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_evidencia";

    function estado()
    {
        return $this->hasOne(Estado::class, 'ID_ESTADO', 'c_i_estado');
    }

    function municipio()
    {
        return $this->hasOne(Municipio::class, 'ID_MUNICIPIO', 'c_i_municipio');
    }

    function localidad()
    {
        return $this->hasOne(Localidad::class, 'ID_LOCALIDAD', 'c_i_localidad');
    }

}
