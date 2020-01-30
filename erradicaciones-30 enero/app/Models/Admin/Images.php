<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\TipoImagen;

class Images extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_imagenes";

    function tipo_imagen()
    {
        return $this->hasOne(TipoImagen::class, 'c_i_timagen', 'c_i_timagen');
    }

}
