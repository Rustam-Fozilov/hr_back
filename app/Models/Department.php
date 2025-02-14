<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'director_id',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'director_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'department_users', 'department_id', 'user_id')->withTimestamps();
    }
}
