<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormDegreeData extends Model
{
    protected $table = 'form_degree_data';

    protected $fillable = [
        'form_id',
        'entrance_year',
        'graduation_year',
        'university',
        'degree',
        'speciality',
        'additional',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
