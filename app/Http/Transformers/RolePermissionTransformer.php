<?php
namespace App\Http\Transformers;

use App\Models\RolePermission;
use Dingo\Api\Contract\Transformer\Adapter;
use Dingo\Api\Transformer\Binding;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

class RolePermissionTransformer extends TransformerAbstract
{
    public function transform(RolePermission $item)
    {
        // Make a call to your transformation layer to transformer the given response.
        return [
            'id' => $item->id,
            'role_id' => $item->role_id,
            'role_name' => $item->role->name,
            'permission_id' => $item->permission_id ?? null,
            'permission_name' => $item->permission->name,
            'is_active' => $item->is_active
        ];
    }
}