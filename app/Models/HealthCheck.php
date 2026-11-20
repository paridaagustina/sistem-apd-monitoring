<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthCheck extends Model
{
    protected $table = 'health_checks';

    protected $fillable = [
        'user_id',
        'nama_petugas',
        'unit',
        'tanggal_periksa',
        'usia',
        'perusahaan',
        'sistolik',
        'diastolik',
        'status_sistolik',
        'status_diastolik',
        'status_tensi',
        'hasil_oximeter',
        'status_oximeter',
        'kesimpulan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_periksa' => 'date',
            'sistolik' => 'integer',
            'diastolik' => 'integer',
            'hasil_oximeter' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}