<?php
namespace App\Http\Transformers;

use App\Models\Role;
use App\Models\RolePermission;
use Dingo\Api\Contract\Transformer\Adapter;
use Dingo\Api\Transformer\Binding;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $item)
    {
        // Make a call to your transformation layer to transformer the given response.
        return [
            'id' => $item->id,
            'code' => $item->code,
            'name' => $item->name,
            'is_active' => $item->is_active
        ];
    }
}