<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepOption extends Model
{
    protected $table = 'step_options';

    protected $fillable = [
        'name',
        'key',
        'step_number',
        'targets',
        'comment',
    ];
}
