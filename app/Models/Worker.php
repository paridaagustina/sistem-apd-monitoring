<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Worker extends Model
{
    protected $table = 'workers';

    protected $fillable = [
        'user_id',
        'worker_code',
        'name',
        'photo',
        'department',
        'position',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(
            ApdInspection::class,
            'worker_id'
        );
    }

    /**
     * Riwayat pemeriksaan kesehatan petugas.
     */
    public function healthChecks(): HasMany
    {
        return $this->hasMany(
            HealthCheck::class,
            'nama_petugas',
            'name'
        );
    }
}