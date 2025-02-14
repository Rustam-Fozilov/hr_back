<?php

namespace Database\Seeders\Once;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public static string $model = User::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'patronymic' => 'Admin',
            'phone' => '998990065551',
            'is_admin' => true,
            'password' => '123456',
            'role_id' => 1,
        ]);
    }
}
