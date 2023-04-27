<?php
namespace App\Http\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

use function PHPUnit\Framework\isEmpty;

class RolePermissionRepository extends BaseRepository 
{
    public function search(array $input = []) {
        $query = RolePermission::query();

        if(isset($input['role_code'])) {
            $role_id = Role::where('code', $input['role_code'])->value('id');
            $query->where('role_id', $role_id);
        }
        
        if(isset($input['limit'])) return $query->paginate($input['limit']);

        return $query->get();
    }
}