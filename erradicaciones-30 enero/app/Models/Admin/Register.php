<?php

namespace App\Models\Admin;
use App\Models\Admin\Plantio;
use App\Models\Admin\Estado;
use App\Models\Admin\Municipio;
use App\Models\Admin\Localidad;
use App\Models\Admin\Dependencia;
use App\Models\Admin\Caracteristicas;
use App\Models\Admin\Evidencia;
use App\Models\Admin\Coordenadas;
use App\Models\Admin\Images;
use App\Models\Admin\Identificacion;
use App\Models\Admin\Dispositive;
use App\Models\Admin\Validation;
use App\Models\Admin\ValidationDasboard;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $connection = 'mysql2';
    protected $table = "o_eventos";

    function plantios()
    {
        return $this->hasMany(Plantio::class, 'c_v_evento', 'c_v_evento');
    }

    function estado()
    {
        return $this->hasOne(Estado::class, 'ID_ESTADO', 'c_i_estado')->select(['ID_ESTADO','NOMBRE']);
    }

    function municipio()
    {
        return $this->hasOne(Municipio::class, 'ID_MUNICIPIO', 'c_i_municipio')->select(['ID_MUNICIPIO','NOMBRE']);
    }

    function localidad()
    {
        return $this->hasOne(Localidad::class, 'ID_LOCALIDAD', 'c_i_localidad')->select(['ID_LOCALIDAD','NOMBRE']);
    }

    function dependencia()
    {
        return $this->hasOne(Dependencia::class, 'c_i_dependencia', 'c_i_dependencia')->select(['c_i_dependencia','d_v_dependencia','d_v_folio']);
    }

    function caracteristicas()
    {
        return $this->hasOne(Caracteristicas::class, 'c_v_evento', 'c_v_evento');
    }

    function coordenada_central()
    {
        return $this->hasOne(Evidencia::class, 'c_v_evento', 'c_v_evento')->select(['c_v_evento','c_i_estado','c_i_municipio','c_i_localidad','n_d_area','d_v_medio','f_t_registro']);
    }

    function coordenadas()
    {
        return $this->hasMany(Coordenadas::class, 'c_v_evento', 'c_v_evento');
    }

    function metadatos()
    {
        return $this->hasMany(Images::class, 'c_v_evento', 'c_v_evento');
    }

    function identificacion()
    {
        return $this->hasOne(Identificacion::class, 'c_v_evento','c_v_evento');
    }

    function dispositivos()
    {
        return $this->hasOne(Dispositive::class, 'imei','n_v_imei');
    }

    function validaciones()
    {
        return $this->hasOne(Validation::class, 'c_v_evento','c_v_evento');
    }

    function validacion_dashboard()
    {
        return $this->hasOne(ValidationDasboard::class, 'id_evento','c_v_evento');
    }
}
