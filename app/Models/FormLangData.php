<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormLangData extends Model
{
    protected $table = 'form_lang_data';

    protected $fillable = [
        'form_id',
        'lang',
        'read_level',
        'write_level',
        'speak_level',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
