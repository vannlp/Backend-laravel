<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends BaseModel
{
    protected $table = "role_permissions";

    protected $fillable = [
        'role_id',
        'permission_id',
        'is_active',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permission() {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}