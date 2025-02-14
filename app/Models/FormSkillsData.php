<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSkillsData extends Model
{
    protected $table = 'form_skills_data';

    protected $fillable = [
        'form_id',
        'ms_word',
        'internet',
        'ms_excel',
        '1c',
        'car_model',
        'car_year',
        'driver_license',
    ];

    public function casts(): array
    {
        return [
            'driver_license' => 'array'
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
