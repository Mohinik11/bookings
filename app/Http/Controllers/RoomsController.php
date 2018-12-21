<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Room;

class RoomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['getAllRooms', 'getRoomById']]);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllRooms()
    {
        try { 
            $rooms = Room::all();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['rooms' => $rooms], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomById($id)
    {
        try {
            $room = Room::where('id', $id)->get();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json($room, 200);
    }
 
}
