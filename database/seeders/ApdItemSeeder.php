<?php

namespace Database\Seeders;

use App\Models\ApdItem;
use Illuminate\Database\Seeder;

class ApdItemSeeder extends Seeder
{
    public function run(): void
    {
        $daftarApd = [
            [
                'name' => 'Helm keselamatan',
                'code' => 'helmet',
            ],
            [
                'name' => 'Rompi reflektif',
                'code' => 'vest',
            ],
            [
                'name' => 'Sepatu keselamatan',
                'code' => 'safety_shoes',
            ],
            [
                'name' => 'Kacamata pelindung',
                'code' => 'goggles',
            ],
            [
                'name' => 'Sarung tangan',
                'code' => 'gloves',
            ],
            [
                'name' => 'Masker / respirator',
                'code' => 'mask',
            ],
        ];

        foreach ($daftarApd as $apd) {
            ApdItem::updateOrCreate(
                ['code' => $apd['code']],
                [
                    'name' => $apd['name'],
                    'is_required' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
