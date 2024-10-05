<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Faker\Factory; // Import the Faker Factory

class UpdateUserData extends Command
{
    protected $faker; // Add this line to declare the property

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
    }

    public function handle()
    {
        //
        $users = \App\Models\User::all();
        $timezones = ['CET', 'CST', 'GMT+1'];

        foreach ($users as $user) {
            $user->name = $this->faker->firstName;
            $user->email = $this->faker->unique()->safeEmail;
            $user->timezone = $timezones[array_rand($timezones)];
            $user->save();
        }

        $this->info('User data updated successfully.');
    }
}
