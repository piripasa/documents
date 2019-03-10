<?php
namespace Tests\Feature\Controllers\Documents;

use Tests\Feature\CrudTest;
use Faker\Factory;

class DocumentControllerTest extends CrudTest
{
    protected $endPoint = "documents";

    public function testIDProvider()
    {        
        $addon = factory(\App\Entities\Documents\Document::class)->create();

        $this->assertTrue($addon->id > 0);

        return $addon->id;
    }

    public function paramProvider()
    {
        $faker = Factory::create();
        return [
            [
                [                    
                    'name' => $faker->name,
                    'file' => $faker->url,
                    'image' => $faker->image,
                ]
            ]
        ];
    }
}
