<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Form extends Model
{
    protected $table = 'forms';

    protected $fillable = [
        'app_id',
        'step_number',
        'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'app_id', 'id');
    }

    public function personal_data(): HasOne
    {
        return $this->hasOne(FormPersonalData::class, 'form_id', 'id');
    }

    public function relative_data(): HasMany
    {
        return $this->hasMany(FormRelativeData::class, 'form_id', 'id');
    }

    public function degree_data(): HasMany
    {
        return $this->hasMany(FormDegreeData::class, 'form_id', 'id');
    }

    public function work_experience_data(): HasMany
    {
        return $this->hasMany(FormWorkExperienceData::class, 'form_id', 'id');
    }

    public function skills_data(): HasOne
    {
        return $this->hasOne(FormSkillsData::class, 'form_id', 'id');
    }

    public function lang_data(): HasMany
    {
        return $this->hasMany(FormLangData::class, 'form_id', 'id');
    }

    public function importance_data(): HasOne
    {
        return $this->hasOne(FormImportanceData::class, 'form_id', 'id');
    }

    public function blitz_data(): HasOne
    {
        return $this->hasOne(FormBlitzData::class, 'form_id', 'id');
    }
}
