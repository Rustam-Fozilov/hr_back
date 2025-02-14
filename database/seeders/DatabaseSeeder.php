<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StepOption;
use Database\Seeders\Once\RoleSeeder;
use Database\Seeders\Once\StatusSeeder;
use Database\Seeders\Once\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public array $once_seeders = [
        RoleSeeder::class,
        UserSeeder::class,
        StatusSeeder::class,
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedOnce();
    }

    public function seedOnce(): void
    {
        $seeders = [];

        foreach ($this->once_seeders as $seed) {
            if (isset($seed::$model) && (!$seed::$model::first())) $seeders[] = $seed;
        }

        if (!empty($seeders)) $this->call($seeders);
    }
}
