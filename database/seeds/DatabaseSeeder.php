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
        DB::table('users')->insert([
            'name' => 'Marie',
            'email' => 'marie@gmail.com',
            'password' => '$2y$10$MUg6sz09ja1d2DNGXPiFoew7ZZkocwWrE9uz.ZbTePoKbvC3HvtNW', // secret,
        ]);

        DB::table('users')->insert([
            'name' => 'William',
            'email' => 'william@gmail.com',
            'password' => '$2y$10$MUg6sz09ja1d2DNGXPiFoew7ZZkocwWrE9uz.ZbTePoKbvC3HvtNW', // secret,
        ]);
    }
}
