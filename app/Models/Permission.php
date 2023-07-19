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

    public static function getPermissionsWithRoles($roleId)
    {
        return Permission::leftJoin('roles_permissions', function ($join) use ($roleId) {
                $join->on('permission.id', '=', 'roles_permissions.permission_id')
                     ->where('roles_permissions.role_id', '=', $roleId);
            })
            ->select('permission.*', 'roles_permissions.*')
            ->get();
    }
}
