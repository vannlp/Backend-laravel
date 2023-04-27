<?php
namespace App\Http\Repositories;

use App\Models\Permission;
use App\Models\Role;

use function PHPUnit\Framework\isEmpty;

class PermissionRepository extends BaseRepository 
{
    public function search(array $input = []) {
        $permission = Permission::query();

        if(isset($input['code'])) {
            $permission->where('code', $input['code']);
        }

        if(isset($input['hide_with_role'])) {
            $input['role_id'] = Role::where('code', $input['hide_with_role'])->value('id');
            $permission->whereDoesntHave('role_permission', function($q) use ($input) {
                $q->where('role_id', $input['role_id']);
            });
        }

        if(isset($input['name'])) {
            $permission->where('name', 'like', "%{$input['code']}%");
        }
        if(isset($input['is_active'])) {
            $permission->where('code', $input['is_active']);
        }

        if(isset($input['group_permission_id'])) {
            $permission->where('group_permission_id', $input['group_permission_id']);
        }

        if(isset($input['search'])) {
            $permission->where(function($q) use ($input) {
                $q->where('code', $input['search'])->orWhere('name', 'like', "%{$input['search']}%");
            });
        }

        if(isset($input['limit'])) return $permission->paginate($input['limit']);

        return $permission->get();
    }
}