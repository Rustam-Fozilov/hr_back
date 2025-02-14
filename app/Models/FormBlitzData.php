<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormBlitzData extends Model
{
    protected $table = 'form_blitz_data';

    protected $fillable = [
        'form_id',
        'work_quality_1',
        'work_quality_2',
        'work_quality_3',
        'weakness',
        'wanted_skills',
        'final_career',
        'reason_for_demission',
        'service_trip_period',
        'criminal_works',
        'networking',
        'networking_fio',
        'where_company_know',
        'start_date',
        'salary',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
