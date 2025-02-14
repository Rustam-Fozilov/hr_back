<?php

namespace App\Models\Role;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'status',
        'color',
        'branch_add',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'branch_add' => 'boolean'
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class,'role_id','id');
    }
}
