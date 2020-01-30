<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Dispositive extends Model
{

    protected $table = "dispositives";
    protected $connection = 'mysql';

    protected $fillable = ['imei','psn','institucion_id','asignacion_id','entidad_id','municipio_id','localidad_id','observaciones'];
    protected $guarded = ['id'];
    public $timestamps = false;

    function asignacion()
    {
        return $this->hasOne(Asignation::class, 'id', 'asignacion_id');
    }

    function dependencia()
    {
        return $this->hasOne(Dependencia::class, 'c_i_dependencia', 'institucion_id');
    }

    function entidad()
    {
        return $this->hasOne(Estado::class, 'ID_ESTADO', 'entidad_id');
    }

    function municipio()
    {
        return $this->hasOne(Municipio::class, 'ID_MUNICIPIO', 'municipio_id');
    }

    function localidad()
    {
        return $this->hasOne(Localidad::class, 'ID_LOCALIDAD', 'localidad_id');
    }

    function eventos(){
        return $this->hasManyThrough(
            Evidencia::class,
            Register::class,
            'n_v_imei',
            'c_v_evento',
            'imei',
            'c_v_evento');
    }
}
