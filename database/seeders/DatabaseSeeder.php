<?php

namespace Database\Seeders;

use App\Models\RemoteSetting;
use App\Models\Translation;
use App\Models\User;
use Database\Factories\RemoteSettingFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        RemoteSetting::factory()->count(1)->create();
        User::factory()->count(1)->create();
        Translation::factory()->count(1)->create();
    }
}
