<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApdItem extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_required',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Satu jenis APD dapat muncul
    // pada banyak detail pemeriksaan
    public function inspectionDetails(): HasMany
    {
        return $this->hasMany(
            ApdInspectionDetail::class
        );
    }
}
