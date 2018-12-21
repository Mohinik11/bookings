<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Customer;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['getAllCustomers', 'getCustomerById']]);
        $this->middleware('authPrivate', ['only' => ['updateCustomerBonusPoints']]);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCustomers()
    {
        try { 
            $customers = Customer::all();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['customers' => $customers], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerById($id)
    {
        try {
            $customer = Customer::where('generate_id', $id)->get();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json($customer, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCustomerBonusPoints(Request $request)
    {
        try {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return response()->json(['error' => 'Required fields missing'], 401);
            }
            $customer = Customer::where('id', $request->input('customer_id'))->first();
            if($customer) {
                $customer->bonus_points = $request->input('bonus_points');
                $customer->updated_by = $request->input('updated_by');
                $customer->save();
            } else {
                return response()->json(['error' => 'Customer not found'], 401);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['success' => 'Bonus Points has been updated successfully'], 200);
    }

    private function validator($data)
    {
        return Validator::make($data, [
          'customer_id' => 'required',
          'bonus_points' => 'required',
          'updated_by' => 'required'
        ]);
    }
}
