<?php
/**
 * User endpoint tests
 *
 * Tests the requests for the user endpoint.  Assumes that there is data in the database
 */

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * Test retrieving users
     *
     * @test
     *
     * @return void
     */
    public function testGetUsers() : void
    {
        $this->json('GET', '/api/users');
        $response = json_decode($this->response->content());
        $this->assertGreaterThan(0, sizeof($response));
        foreach ($response as $user) {
            $this->assertObjectHasAttribute('name', $user);
        }
    }

    /**
     * Tests getting a single user
     *
     * @depends testGetUsers
     *
     * @test
     *
     * @return void
     */
    public function testGetUser() : void
    {
        $id = $this->getSingleUser();
        $this->json('GET', "/api/users/$id");
        $entityResponse = json_decode($this->response->content());
        $this->assertInstanceOf('stdClass', $entityResponse);
        $this->assertObjectHasAttribute('id', $entityResponse);
        $this->assertObjectHasAttribute('name', $entityResponse);
    }

    /**
     * Tests updating a user
     *
     * @depends testGetUser
     *
     * @test
     *
     * @return void
     */
    public function testUpdateUser() : void
    {
        $id          = $this->getSingleUser();
        $newUserName = md5(rand(1,199));
        $this->json('PUT', "/api/users/$id", ['name' => $newUserName]);
        $this->json('GET', "/api/users/$id");
        $response = json_decode($this->response->content());
        $this->assertEquals($newUserName, $response->name);
    }

    /**
     * Test creating a user
     *
     * @test
     *
     * @return void
     */
    public function testCreateUser() : void
    {
        $newUserName = md5(rand(1,199));
        $this->json('POST', "/api/users/", ['name' => $newUserName]);
        $response = json_decode($this->response->content());
        $this->assertObjectHasAttribute('id', $response);
        $this->assertEquals($newUserName, $response->name);
    }

    /**
     * Get a single user record back
     *
     * @return int
     */
    public function getSingleUser() : int
    {
        $this->json('GET', '/api/users');
        $response = json_decode($this->response->content());
        $this->assertGreaterThan(0, sizeof($response));
        return $response[0]->id;

    }
}