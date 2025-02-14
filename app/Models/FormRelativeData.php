<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormRelativeData extends Model
{
    protected $table = 'form_relative_data';

    protected $fillable = [
        'form_id',
        'relative_type',
        'fio',
        'birth_date',
        'work_place',
        'living_address',
        'phone',
        'ordering',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
