<?php
namespace App\Http\Transformers;

use App\Models\Permission;
use App\Models\RolePermission;
use Dingo\Api\Contract\Transformer\Adapter;
use Dingo\Api\Transformer\Binding;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $item)
    {
        // Make a call to your transformation layer to transformer the given response.
        return [
            'id' => $item->id,
            'code' => $item->code,
            'name' => $item->name,
            'is_active' => $item->is_active ?? null,
            'group_permission_id' => $item->group_permission_id ?? null,
            'description' => $item->description
        ];
    }
}