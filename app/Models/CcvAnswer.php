<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CcvAnswer extends Model
{
    protected $fillable = [
        'ccv_observation_id',
        'risk_code',
        'question_key',
        'question_text',
        'answer',
    ];

    public function observation(): BelongsTo
    {
        return $this->belongsTo(CcvObservation::class, 'ccv_observation_id');
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(CcvEvidence::class);
    }
}