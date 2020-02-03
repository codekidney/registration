<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Populate roles
//        factory(App\ProgrammingLanguages::class, 10)->create();

        // Populate users
        factory(App\User::class, 50)->create();

        // Get all the roles attaching up to 3 random roles to each user
        $langs = App\ProgrammingLanguages::all();

        // Populate the pivot table
        App\User::all()->each(function ($user) use ($langs) { 
            $user->languages()->attach(
                $langs->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
    }
}
