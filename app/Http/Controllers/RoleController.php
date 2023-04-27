<?php

namespace App\Http\Controllers;

use App\Http\Repositories\RoleRepository;
use App\Http\Transformers\RoleTransformer;
use App\Models\Role;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function listAdmin(Request $request) {
        $input = $request->all();
        try {
            $roles = (new RoleRepository())->search($input);

            if(isset($input['limit'])) {
                return $this->response->paginator($roles, new RoleTransformer());
            }else{
                return $this->response->collection($roles, new RoleTransformer());
            }
        } catch (\Exception $ex) {
            return $this->response->error($ex->getMessage(), $ex->getCode());
        }
    }


    public function addRole(Request $request) {
        $request->validate([
            'code' => ['required', 'unique:roles,code'],
            'name' => ['required']
        ],[
            'code.required' => "Mã không được bỏ trống",
            'code.unique' => "Mã đã tồn tại",
            'name.required' => "Tên đã tồn tại"
        ]);
        $input = $request->all();

        try {
            //code...
            DB::beginTransaction();
            $input['code'] = strtoupper($input['code']);
            Role::create($input);
            DB::commit();
            return $this->responeSuccess('Thêm mới thành công');
            
        } catch (\Exception $ex) {
            DB::rollBack();
            //throw $th;
            return $this->response->error($ex->getMessage(), $ex->getCode());
        }
    }
}
