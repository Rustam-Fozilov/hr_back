<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'parent_id',
        'is_parent',
        'title',
        'key',
        'type',
        'options'
    ];
}
