<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolePerm extends Model
{
    protected $table = 'role_perms';

    protected $fillable = [
        'role_id',
        'permission_id',
        'key',
        'value',
    ];

    public function permission(): HasOne
    {
        return $this
            ->hasOne(Permission::class,'id','permission_id')
            ->select(['id', 'key', 'title', 'parent_id', 'is_parent', 'type', 'options']);
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class,'id','role_id')->select(['id','name','status']);
    }
}
