<?php
namespace Tests\Feature\Controllers;

use Tests\TestCase;

class SwaggerControllerTest extends TestCase
{
    public function testSwagger()
    {
        $this->json('GET', '/api/v2/swagger.json')
            ->seeJson([
                'swagger' => '2.0'
            ]);
    }
}
