<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\RoomsController;
use App\Room;

class RoomsControllerTest extends TestCase
{
	private $controller;

	public function setUp()
	{
		$this->controller = new RoomsController();
		parent::setUp();
	}

	public function tearDown()
	{
		$this->controller = null;
		parent::tearDown();
	}
	
    /**
     *
     * @return void
     */
    public function testGetRoomsSuccess()
    {
    	$this->get('/rooms', ['Api-Token' => 'publicKey']);
       	$this->assertEquals(200, $this->response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($this->response->getData()->rooms));
    }

	public function testGetRoomsUnauthorized()
    {
    	$this->get('/rooms');
       	$this->assertEquals(401, $this->response->getStatusCode());
       	$this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    public function testGetRoomById()
    {
    	$this->get('/room/1', ['Api-Token' => 'publicKey']);
    	$this->assertEquals(200, $this->response->getStatusCode());
    }

}
