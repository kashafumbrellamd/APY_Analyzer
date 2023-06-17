<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $table = "permission";
    use HasFactory;

    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }

    public function users() {
        return $this->belongsToMany(User::class,'users_permissions');
    }

    public function getPermissionsWithRoles()
    {
        return Permission::leftJoin('roles_permissions', 'permission.id', '=', 'roles_permissions.permission_id')
            ->select('permission.*', 'roles_permissions.*')
            ->get();
    }
}
