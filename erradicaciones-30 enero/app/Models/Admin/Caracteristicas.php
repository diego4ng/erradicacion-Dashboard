<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ManejoCultural;
use App\Models\Admin\MetodoSiembra;
use App\Models\Admin\Clima;
use App\Models\Admin\Terreno;
use App\Models\Admin\Riego;
use App\Models\Admin\Accesibilidad;

class Caracteristicas extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_caracteristicas";

    function metodoErradicacion()
    {
        return $this->hasOne(MetodoErradicacion::class, 'c_i_merradica', 'c_i_merradica');
    }

    function manejoCultural()
    {
        return $this->hasOne(ManejoCultural::class, 'c_i_manejoc', 'c_i_manejoc');
    }

    function metodoSiembra()
    {
        return $this->hasOne(MetodoSiembra::class, 'c_i_msiembra', 'c_i_msiembra');
    }

    function clima()
    {
        return $this->hasOne(Clima::class, 'c_i_clima', 'c_i_clima');
    }

    function terreno()
    {
        return $this->hasOne(Terreno::class, 'c_i_terreno', 'c_i_terreno');
    }

    function mimetizacion()
    {
        return $this->hasOne(Mimetizacion::class, 'c_i_mimetizacion', 'c_i_mimetizacion');
    }

    function riego()
    {
        return $this->hasOne(Riego::class, 'c_i_riego', 'c_i_riego');
    }

    function accesibilidad()
    {
        return $this->hasOne(Accesibilidad::class, 'c_i_accesibilidad', 'c_i_accesibilidad');
    }

    function terrestre()
    {
        return $this->hasOne(Terrestre::class, 'c_i_accesot', 'c_i_accesot');
    }

}
