<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApdInspectionDetail extends Model
{
    protected $fillable = [
        'inspection_id',
        'apd_item_id',
        'is_detected',
        'confidence',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_detected' => 'boolean',
            'confidence' => 'decimal:4',
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(
            ApdInspection::class,
            'inspection_id'
        );
    }

    public function apdItem(): BelongsTo
    {
        return $this->belongsTo(ApdItem::class);
    }
}
