<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStep extends Model
{
    protected $table = 'application_steps';

    protected $fillable = [
        'name',
        'key',
        'step_number',
        'targets',
        'comment',
    ];
}
