<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use App\Booking;
use App\Room;

class BookingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function CreateBooking(Request $request)
    {
        try {
        	$validator = $this->validator($request->all());
        	if ($validator->fails()) {
	            return response()->json(['error' => 'Required fields missing'], 401);
	        }

        	$customerId = $request->input('customer_id');
        	$roomId = $request->input('room_id');

        	$room = Room::find($roomId);
        	$customer = Customer::find($customerId);
        	if(!$customer) {
        		return response()->json(['error' => 'Customer not found.'], 401);
        	} else if ($this->checkAvailability($room)) {
        		$this->bookRoom($room, $customer);
        	} else {
        		return response()->json(['error' => 'Room is sold out.'], 401);
        	}
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['success' => 'Congratulations!! Room has been booked.'], 200);
    }


    private function checkAvailability($room)
    {
    	return $room->available_amount && $room->available_amount > 0 ;
    }

    private function bookRoom($room, $customer)
    {
    	if($customer->bonus_points >= $room->required_points) {
    		$status = 'RESERVED';
			$this->subtractCustomerBonus($customer, $room->required_points);
		} else {
    		$status = 'PENDING_APPROVAL';
		}

		$booking = ['customer_id' => $customer->id, 'room_id' => $room->id, 'status' => $status];
		Booking::create($booking);
		$this->updateRoomAmount($room);

		Mail::raw(
			'Booking has been done by customer ' . $customer->name . ' with status ' . $status, 
			function($msg) {
		 		$msg->to([env('ADMIN_EMAIL')])->subject('Room Status Changed'); 
		 		$msg->from([env('ADMIN_EMAIL')]); 
			}
		);
    }

    private function subtractCustomerBonus($customer, $points=0)
    {
    	$customer->bonus_points = $customer->bonus_points - $points;
    	$customer->save();
    }

    private function updateRoomAmount($room)
    {
    	$room->available_amount = $room->available_amount - 1;
    	$room->save();
    }

    private function validator($data)
    {
        return Validator::make($data, [
          'customer_id' => 'required',
          'room_id' => 'required'
        ]);
    }

}
