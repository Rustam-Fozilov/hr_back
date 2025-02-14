<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormWorkExperienceData extends Model
{
    protected $table = 'form_work_experience_data';

    protected $fillable = [
        'form_id',
        'start_date',
        'end_date',
        'company_name',
        'position',
        'company_person_count',
        'under_person_count',
        'activities',
        'reason_for_leaving',
        'salary',
        'achievements',
        'ordering',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
