<?php
namespace App\Http\Repositories;

use App\Models\Permission;
use App\Models\Role;

use function PHPUnit\Framework\isEmpty;

class RoleRepository extends BaseRepository 
{
    public function search(array $input = []) {
        $role = Role::query();

        if(isset($input['code'])) {
            $role->where('code', $input['code']);
        }

        if(isset($input['name'])) {
            $role->where('name', 'like', "%{$input['code']}%");
        }
        if(isset($input['is_active'])) {
            $role->where('code', $input['is_active']);
        }


        if(!empty($input['limit'])) {
            return $role->paginate($input['limit']);
        }else{
            return $role->get();
        }
    }
}