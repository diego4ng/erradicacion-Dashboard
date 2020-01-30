<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Asignation extends Model
{
    protected $table = "asignations";
    protected $fillable = ['descripcion'];
    protected $guarded = ['id'];
    public $timestamps = false;
}
