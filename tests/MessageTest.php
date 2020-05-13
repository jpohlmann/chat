<?php
/**
 * Message endpoint tests
 *
 * Tests the requests for the message endpoint.  Assumes that there is data in the database
 *
 * @author Justin Pohlmann
 */

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MessageTest extends TestCase
{
    /**
     * Test retrieving messages
     *
     * @test
     *
     * @return void
     */
    public function testGetMessages() : void
    {
        $this->json('GET', '/api/messages');
        $response = json_decode($this->response->content());
        $this->assertGreaterThan(0, sizeof($response));
        foreach ($response as $message) {
            $this->assertObjectHasAttribute('message', $message);
        }
    }

    /**
     * Tests getting a single message
     *
     * @depends testGetMessages
     *
     * @test
     *
     * @return void
     */
    public function testGetMessage() : void
    {
        $id = $this->getSingleMessage()->id;
        $this->json('GET', "/api/messages/$id");
        $entityResponse = json_decode($this->response->content());
        $this->assertInstanceOf('stdClass', $entityResponse);
        $this->assertObjectHasAttribute('id', $entityResponse);
        $this->assertObjectHasAttribute('message', $entityResponse);
    }

    /**
     * Tests updating a message
     *
     * @depends testGetMessage
     *
     * @test
     *
     * @return void
     */
    public function testUpdateMessage() : void
    {
        $id          = $this->getSingleMessage()->id;
        $newMessageName = md5(rand(1,199));
        $this->json('PUT', "/api/messages/$id", ['message' => $newMessageName]);
        $this->json('GET', "/api/messages/$id");
        $response = json_decode($this->response->content());
        $this->assertEquals($newMessageName, $response->message);
    }

    /**
     * Test creating a message
     *
     * @test
     *
     * @return void
     */
    public function testCreateMessage() : void
    {
        $message = $this->getSingleMessage();
        $newMessage = md5(rand(1,199));
        $this->json('POST', "/api/messages/", [
            'message' => $newMessage,
            'sender_id' => $message->sender_id,
            'recipient_id' => $message->recipient_id
        ]);
        $response = json_decode($this->response->content());
        $this->assertObjectHasAttribute('id', $response);
        $this->assertEquals($newMessage, $response->message);
    }

    /**
     * Get a single message record back
     *
     * @return int
     */
    public function getSingleMessage() : stdClass
    {
        $this->json('GET', '/api/messages');
        $response = json_decode($this->response->content());
        $this->assertGreaterThan(0, sizeof($response));
        return $response[0];

    }
}