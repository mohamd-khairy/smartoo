<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\RemoteSetting;
use App\Models\Subscription;
use App\Models\Translation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
        RemoteSetting::factory()->count(1)->create();
        User::factory()->count(1)->create();
        Translation::factory()->count(1)->create();
        Plan::factory()->count(5)->create();
        Subscription::factory()->count(5)->create();
    }
}
