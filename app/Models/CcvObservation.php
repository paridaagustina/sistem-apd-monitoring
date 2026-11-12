<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CcvObservation extends Model
{
    protected $fillable = [
        'user_id',
        'observer_name',
        'company',
        'position',
        'department',
        'unit_induk',
        'work_location',
        'work_order_number',
        'executing_unit',
        'customer_service_unit',
        'supervisor_present',
        'risk_code',
        'other_risk',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'supervisor_present' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(CcvAnswer::class);
    }
}