<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ValidationDasboard extends Model
{
        protected $connection = "mysql";
        protected $table = "validation";

    protected $fillable = ['_token', 'id_evento', 'observaciones_validador', 'total_puntos', 'estatus_validacion', 'id_usuario_validador','total_puntos','total_datos','imei','seguridad','transmision','integridad','suficiencia','diferencia_dias','georeferencia','evidencia'];

        function usuario_validador()
    {
        return $this->hasOne(Authenticatable::class, 'id','id_usuario_validador')->select(['id','name']);
    }
}
