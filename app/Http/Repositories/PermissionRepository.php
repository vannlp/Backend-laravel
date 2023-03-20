<?php
namespace App\Http\Repositories;

use App\Models\Permission;

use function PHPUnit\Framework\isEmpty;

class PermissionRepository extends BaseRepository 
{
    public function search(array $input = []) {
        $permission = Permission::query();

        if(isset($input['code'])) {
            $permission->where('code', $input['code']);
        }

        if(isset($input['name'])) {
            $permission->where('name', 'like', "%{$input['code']}%");
        }
        if(isset($input['is_active'])) {
            $permission->where('code', $input['is_active']);
        }
    }
}