<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CcvEvidence extends Model
{
    protected $fillable = [
        'ccv_answer_id',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function answer(): BelongsTo
    {
        return $this->belongsTo(CcvAnswer::class, 'ccv_answer_id');
    }
}