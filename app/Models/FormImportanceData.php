<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormImportanceData extends Model
{
    protected $table = 'form_importance_data';

    protected $fillable = [
        'form_id',
        'salary',
        'stability',
        'new_skills',
        'flexible_work_hours',
        'work_interest',
        'team_env',
        'work_in_office',
        'company_rating',
        'near_home',
        'career_growth',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
