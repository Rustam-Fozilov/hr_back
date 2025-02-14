<?php

namespace Database\Seeders\Once;

use App\Models\Role\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public static string $model = Role::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->create([
            'name' => 'Admin',
        ]);
    }
}
