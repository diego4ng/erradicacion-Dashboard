<?php

namespace App\Models\Admin;
use App\Models\Admin\Evidencia;
use App\Models\Admin\Register;
use App\Models\Admin\Etapa;
use App\Models\Admin\ColorFlor;

use Illuminate\Database\Eloquent\Model;

class Plantio extends Model
{
    protected $connection = 'mysql2';
    protected $table = "d_plantio";

    function tipoPlantio()
    {
        return $this->hasOne(TipoPlantio::class, 'c_i_tplantio', 'c_i_tplantio');
    }

    function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'c_i_presentacion','c_i_presentacion');
    }

    function etapa()
    {
        return $this->hasOne(Etapa::class, 'c_i_etapa','c_i_etapa');
    }

    function color_flor()
    {
        return $this->hasOne(ColorFlor::class, 'c_i_cflor','c_i_cflor');
    }

    function areaErradicada()
    {
        return $this->hasOne(Evidencia::class, 'c_v_evento','c_v_evento')->select(['c_v_evento', 'n_d_area']);
    }

    function institucion_erradica()
    {
        return $this->hasOne(Register::class, 'c_v_evento','c_v_evento')->select(['c_v_evento','c_i_dependencia','f_t_captura','n_v_imei','f_t_registro']);
    }

}
