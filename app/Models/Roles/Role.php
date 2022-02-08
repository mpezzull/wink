<?php

namespace App\Models\Roles;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function getPermissionsCountAttribute()
    {
        return Permission::count();
    }
}
