<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\CustomersController;
use App\Customer;

class CustomersControllerTest extends TestCase
{
	private $controller;

	public function setUp()
	{
		$this->controller = new CustomersController();
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
    public function testGetCustomersSuccess()
    {
    	$this->get('/customers', ['Api-Token' => 'publicKey']);
       	$this->assertEquals(200, $this->response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($this->response->getData()->customers));
    }

	public function testGetCustomersUnauthorized()
    {
    	$this->get('/customers');
       	$this->assertEquals(401, $this->response->getStatusCode());
       	$this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    public function testGetCustomerById()
    {
    	$this->get('/customer/1', ['Api-Token' => 'publicKey']);
    	$this->assertEquals(200, $this->response->getStatusCode());
    }

    public function testUpdateCustomerUnauthorized()
    {
    	$this->put('/customer/bonus', ['bonus_points' => 100], ['Api-Token' => 'publicKey']);
    	$this->assertEquals(401, $this->response->getStatusCode());
       	$this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    public function testUpdateCustomerBonusMissingInfo()
    {
    	$this->put('/customer/bonus', ['bonus_points' => 100], ['Api-Token' => 'privateKey']);
    	$this->assertEquals(401, $this->response->getStatusCode());
    	$this->assertEquals('Required fields missing', $this->response->getData()->error);
    }

    public function testUpdateCustomerBonusNotFound()
    {
    	$this->put(
    		'/customer/bonus', 
    		['bonus_points' => 100, 'customer_id' => 100, 'updated_by' => 1], 
    		['Api-Token' => 'privateKey']
    	);
    	$this->assertEquals(401, $this->response->getStatusCode());
    	$this->assertEquals('Customer not found', $this->response->getData()->error);
    }

    public function testUpdateCustomerBonusSuccess()
    {
    	$this->put(
    		'/customer/bonus', 
    		['bonus_points' => 400, 'customer_id' => 1, 'updated_by' => 1], 
    		['Api-Token' => 'privateKey']
    	);
    	$this->assertEquals(200, $this->response->getStatusCode());
    	$this->assertEquals('Bonus Points has been updated successfully', $this->response->getData()->success);
    }
}
