<?php

namespace Database\Seeders\Once;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public static string $model = Status::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::query()->firstOrCreate(
            [
                'id' => 1,
            ],
            [
                'name' => 'Active',
                'key' => 'active',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 2
            ],
            [
                'name' => 'Inactive',
                'key' => 'inactive',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 3
            ],
            [
                'name' => 'Open',
                'key' => 'open',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 4,
            ],
            [
                'name' => 'Closed without payment',
                'key' => 'closed_without_payment',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 5,
            ],
            [
                'name' => 'Closed with payment',
                'key' => 'closed_with_payment',
            ]
        );

        // HR
        Status::query()->firstOrCreate(
            [
                'id' => 6,
            ],
            [
                'name' => 'Hire',
                'key' => 'hire',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 7,
            ],
            [
                'name' => 'Fire',
                'key' => 'fire',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 8,
            ],
            [
                'name' => 'Imzolanmagan',
                'key' => 'not_signed',
            ]
        );
        Status::query()->firstOrCreate(
            [
                'id' => 9,
            ],
            [
                'name' => 'Imzolangan',
                'key' => 'signed',
            ]
        );

        Status::query()->firstOrCreate(
            [
                'id' => 10,
            ],
            [
                'name' => 'Oldindan to\'lov',
                'key' => 'prepayment',
            ]
        );

        Status::query()->firstOrCreate(
            [
                'id' => 11,
            ],
            [
                'name' => 'To\'liq to\'lov',
                'key' => 'full_payment',
            ]
        );

        Status::query()->firstOrCreate(
            [
                'id' => 12,
            ],
            [
                'name' => 'Keyin to\'lov',
                'key' => 'post_payment',
            ]
        );

        Status::query()->firstOrCreate(
            [
                'id' => 13,
            ],
            [
                'name' => 'Oylik to\'lov',
                'key' => 'monthly_payment',
            ]
        );

        Status::query()->firstOrCreate(
            [
                'id' => 14,
            ],
            [
                'name' => 'Qisman to\'langan',
                'key' => 'paid_partly',
            ]
        );
    }
}
