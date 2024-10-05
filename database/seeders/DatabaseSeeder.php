<?php

namespace Database\Seeders;

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
        $timezones = ['CET', 'CST', 'GMT+1'];

        User::factory(20)->create()->each(function ($user) use ($timezones) {
            $user->timezone = $timezones[array_rand($timezones)];
            $user->save();
        });
    }
}
