<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\BookingsController;
use App\Booking;
use App\Room;

class BookingsControllerTest extends TestCase
{
	private $controller;

	public function setUp()
	{
		$this->controller = new BookingsController();
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
    public function testCreateBookingMissingInfo()
    {
    	$this->post('/booking', ['room_id' => 1], ['Api-Token' => 'publicKey']);
       	$this->assertEquals(401, $this->response->getStatusCode());
    	$this->assertEquals('Required fields missing', $this->response->getData()->error);
    }

 	public function testCreateBookingUnauthorized()
    {
    	$this->post('/booking', ['room_id' => 1]);
       	$this->assertEquals(401, $this->response->getStatusCode());
       	$this->assertEquals('Unauthorized.', $this->response->getContent());
    }

	public function testCreateBookingCustomerNotFound()
    {
    	$this->post('/booking', ['room_id' => 1, 'customer_id' => 200], ['Api-Token' => 'publicKey']);
       	$this->assertEquals(401, $this->response->getStatusCode());
    	$this->assertEquals('Customer not found.', $this->response->getData()->error);
    }

	public function testCreateBookingRoomSoldOut()
    {
    	$room = Room::find(1);
    	$room->available_amount = 0;
    	$room->save();
    	$this->post('/booking', ['room_id' => 1, 'customer_id' => 2], ['Api-Token' => 'publicKey']);
       	$this->assertEquals(401, $this->response->getStatusCode());
    	$this->assertEquals('Room is sold out.', $this->response->getData()->error);
    }

	public function testCreateBookingSuccess()
    {
    	$room = Room::find(1);
    	$room->available_amount = 2;
    	$room->save();
    	$this->post('/booking', ['room_id' => 1, 'customer_id' => 2], ['Api-Token' => 'publicKey']);
       	$this->assertEquals(200, $this->response->getStatusCode());
    	$this->assertEquals('Congratulations!! Room has been booked.', $this->response->getData()->success);
    }

}
