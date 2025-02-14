<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        'status',
        'name',
        'address',
        'location',
        'token',
        'region_id',
        'phones',
        'link',
        'info',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'branch_users', 'branch_id', 'user_id')->withTimestamps();
    }
}
