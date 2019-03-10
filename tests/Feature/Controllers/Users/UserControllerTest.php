<?php
namespace Tests\Feature\Controllers\Users;

use Tests\Feature\CrudTest;
use Faker\Factory;

class UserControllerTest extends CrudTest
{
    protected $endPoint = "users";

    public function testIDProvider()
    {
        $user = factory(\App\Entities\Users\User::class)->create();

        $this->assertTrue($user->id > 0);

        return $user->id;
    }

    public function paramProvider()
    {
        $faker = Factory::create();
        return [
            [
                [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => "123456",
                    'confirm_password' => "123456"
                ]
            ]
        ];
    }
}
