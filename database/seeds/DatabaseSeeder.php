<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DocumentsTableSeeder::class,
            UsersTableSeeder::class
        ]);

        $this->command->info('Database Seeder run successfully.');
    }
}
