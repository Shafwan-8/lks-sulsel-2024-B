<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Models\event_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $data = event::all();

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $event = event::find($id);

        if (is_null($event)) {
            return response()->json([
                'code' => 201,
                'message' => 'Event not found',
            ], 201);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $event
        ], 200);
    }


    public function register(Request $request)
    {
        $event_id = event::pluck('id')->random();
        $payment_methods = ['gopay', 'bca', 'bri', 'bni', 'mandiri', 'dana', 'ovo'];

        $request->request->add([
            'event_id' => $event_id,
            'status' => 1,
            'payment' => $payment_methods[array_rand($payment_methods)],
            'ticket_number' => rand(10000, 99999),
        ]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event_id' => 'required|integer|exists:events,id',
            'status' => 'required|integer|in:0,1',
            'payment' => 'required|string',
            'ticket_number' => 'required|integer',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'code' => 422,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
        else
        {
            $data = $validator->validated();

            event_register::create($data);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => null
            ], 200);
        }
    }
}