<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Role;
use App\User;

class UserRole extends Model
{
    protected $table = "user_role";
    protected $fillable = ['role_id','user_id','status'];
    protected $guarded = ['id'];

    function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    function usuario()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
