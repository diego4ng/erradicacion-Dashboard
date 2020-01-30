<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Dependencia;
use App\Models\Admin\Region;
use App\Models\Admin\Armas;
use App\Models\Admin\Unidad;

class Identificacion extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_identificacion";

    function dependencia()
    {
        return $this->hasOne(Dependencia::class, 'c_i_dependencia', 'c_i_dependencia')->select(['c_i_dependencia','d_v_dependencia']);
    }

    function region_militar()
    {
        return $this->hasOne(Region::class, 'c_i_regionm', 'c_i_regionm')->select(['c_i_regionm','d_v_regionm']);
    }

    function armas()
    {
        return $this->hasOne(Armas::class, 'c_i_armace', 'c_i_armasce')->select(['c_i_armace','d_v_armace']);
    }

    function unidad()
    {
        return $this->hasOne(Unidad::class, 'c_i_unidad', 'c_i_unidad')->select(['c_i_unidad','d_v_unidad']);
    }

}
