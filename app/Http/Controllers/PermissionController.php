<?php

namespace App\Http\Controllers;

use App\Http\Transformers\RolePermissionTransformer;
use App\Models\RolePermission;
use Illuminate\Http\Request;

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
}
