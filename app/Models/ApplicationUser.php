<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationUser extends Model
{
    protected $table = 'application_users';

    protected $fillable = [
        'app_id',
        'name',
        'surname',
        'patronymic',
        'phone',
        'pinfl',
        'passport_code',
        'passport_number',
        'passport_date',
        'passport_end_date',
        'position_id',
        'branch_id',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
