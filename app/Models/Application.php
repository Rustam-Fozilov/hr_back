<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'user_id',
        'type_id',
        'step_number',
        'hire_date',
        'fire_date',
        'app_fire_date',
        'fire_reason',
        'workload_type',
        'status',
        'owner_id',
        'contract_duration',
        'intern_duration',
    ];

    protected function casts(): array
    {
        return [
            'intern_duration' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function app_user(): HasOne
    {
        return $this->hasOne(ApplicationUser::class, 'app_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'type_id', 'id');
    }

    public function uploads(): BelongsToMany
    {
        return $this->belongsToMany(Upload::class, 'application_uploads', 'application_id', 'upload_id')
            ->select(['uploads.*', 'application_uploads.type as app_type'])
            ->withTimestamps();
    }

    public function history()
    {
        return $this->hasMany(ApplicationHistory::class, 'application_id', 'id')->with(['user']);
    }

    public function workloads()
    {
        return $this->hasMany(ApplicationWorkload::class, 'application_id', 'id')->with(['department', 'branch']);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function form(): HasOne
    {
        return $this->hasOne(Form::class, 'app_id', 'id');
    }
}
