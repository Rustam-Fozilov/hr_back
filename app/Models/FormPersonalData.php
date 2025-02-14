<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormPersonalData extends Model
{
    protected $table = 'form_personal_data';

    protected $fillable = [
        'form_id',
        'birth_address',
        'phone',
        'phone_home',
        'phone_work',
        'email',
        'living_address',
        'family_status',
        'dress_size',
        'smoke_status',
        'drink_status',
        'citizenship',
        'nationality',
        'birth_date',
        'phone_other',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
