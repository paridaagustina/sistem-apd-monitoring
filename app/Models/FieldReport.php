<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldReport extends Model
{
    protected $fillable = [
        'user_id',
        'location_name',
        'started_at',
        'ended_at',
        'submitted_at',
        'video_path',
        'video_duration',
        'video_size',
        'status',
        'notes',

         // Data GPS
    'latitude',
    'longitude',
    'location_accuracy',
    ];

    protected function casts(): array
{
    return [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'submitted_at' => 'datetime',
        'video_duration' => 'integer',
        'video_size' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'location_accuracy' => 'float',
    ];
}

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}