<?php
namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HealthTest extends TestCase
{
    public function testHealth()
    {
        $this->get('/api/v1/health');

        $this->assertEquals(
            "OK", $this->response->getContent()
        );
    }
}
