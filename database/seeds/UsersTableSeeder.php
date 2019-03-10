<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();

        factory(App\Entities\Users\User::class, 3)->create();

        factory(App\Entities\Users\User::class)->create([
            'name' => "Zaman",
            'email' => "zaman@test.test",
            'password' => '123456'
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
