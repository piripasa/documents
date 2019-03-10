<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\AttachJwtToken;

abstract class CrudTest extends TestCase
{
    use AttachJwtToken;

    protected $endPoint;
    protected $apiBasePath = "api/v1";

    /**
     * @depends testIDProvider
     */
    public function testIndexAll()
    {
        $response = $this->call("GET",
            sprintf("%s/%s", $this->apiBasePath, $this->endPoint)
        )->getOriginalContent();

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertCount(2, $response);
    }

    /**
     * @depends testIDProvider
     */
    public function testIndexById($id)
    {
        $response = $this->call("GET",
            sprintf("%s/%s/%d", $this->apiBasePath, $this->endPoint, $id)
        )->getOriginalContent();

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertGreaterThan(0, $response['id']);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testCreate($params)
    {
        $response = $this->call("POST",
            sprintf("%s/%s", $this->apiBasePath, $this->endPoint),
            $params
        )->getOriginalContent();

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }

    /**
     * @dataProvider paramProvider
     * @depends testIDProvider
     */
    public function testUpdate($params, $id)
    {
        $response = $this->call("PUT",
            sprintf("%s/%s/%d", $this->apiBasePath, $this->endPoint, $id),
            $params
        )->getOriginalContent();

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }

    /**
     * @depends testIDProvider
     */
    public function testDelete($id)
    {
        $response = $this->call("DELETE",
            sprintf("%s/%s/%d", $this->apiBasePath, $this->endPoint, $id)
        )->getOriginalContent();

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }
}
