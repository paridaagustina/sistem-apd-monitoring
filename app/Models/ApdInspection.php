<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApdInspection extends Model
{
    
protected $fillable = [
    'user_id',
    'worker_id',
    'started_at',
    'ended_at',
    'status',
    'evidence_path',
    'notes',
];

public function worker()
{
    return $this->belongsTo(Worker::class, 'worker_id');
}


    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    // Petugas yang melakukan pemeriksaan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Daftar APD yang diperiksa
    public function details(): HasMany
    {
        return $this->hasMany(
            ApdInspectionDetail::class,
            'inspection_id'
        );
    }
}
