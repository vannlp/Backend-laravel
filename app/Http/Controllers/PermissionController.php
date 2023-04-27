<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PermissionRepository;
use App\Http\Repositories\RolePermissionRepository;
use App\Http\Transformers\PermissionTransformer;
use App\Http\Transformers\RolePermissionTransformer;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function getPermissionByUser(Request $request) {
        $input = $request->all();
        $role_id = auth()->user()->role_id ?? null;
        if(!$role_id) {
            return $this->response->error('Bạn chưa đăng nhập', 400);
        }
        $role_permission = RolePermission::where('role_id', $role_id)->where('is_active', 1)->get();


        return $this->response->collection($role_permission, new RolePermissionTransformer());
    }

    public function getPermission(Request $request) {
        $input = $request->all();

        try {
            $permissions = (new PermissionRepository())->search($input);

            if(isset($input['limit'])) return $this->response->paginator($permissions, new PermissionTransformer());
            else return $this->response->collection($permissions, new PermissionTransformer());
        } catch (\Exception $th) {
            //throw $th;

            return $this->response->error($th->getMessage(), $th->getCode());
        }
    }

    public function createPermission(Request $request) {
        $request->validate([
            'code' => "required|unique:permissions",
            'name' => "required|unique:permissions",
            'is_active' => "required",
            'description' =>"required"
        ]);

        try {
            DB::beginTransaction();
            $input = $request->all();

            $create_data = [
                'code' => $input['code'],
                'name' => $input['name'],
                'is_active' => $input['is_active'] ?? 0,
                'description' => $input['description'],
                'group_permission_id' => $input['group_permission_id'] ?? null,
                'created_by' => auth()->user()->id
            ];

            Permission::create($create_data);
            DB::commit();
            return $this->responeSuccess("Thêm mới thành công");
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->response->error($th->getMessage(), $th->getCode());
        }
    }

    public function listRolePermission(Request $request) {
        $input = $request->all();

        if(isset($input['limit'])) {
            $input['limit'] = 10;
        }

        $role_permission = (new RolePermissionRepository())->search($input);

        return $this->response->paginator($role_permission, new RolePermissionTransformer());
    }
}
