<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationUpload extends Model
{
    protected $table = 'application_uploads';

    protected $fillable = [
        'application_id',
        'upload_id',
        'type',
        'comment',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function upload(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }
}
