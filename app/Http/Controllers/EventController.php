<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Models\event_register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $data = event::all();

        foreach ($data as $key => $value) {
            $user = User::find($value->user_id);
            $data[$key]->user = $user->name;
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

    public function show($id)
    {
        $event = event::find($id);
        $user = User::where('id', $event->user_id)->first();
        $event->user = $user->name;

        if (is_null($event)) {
            return response()->json([
                'code' => 201,
                'message' => 'Event not found',
                'data' => null
            ], 201);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $event
        ], 200);
    }

    public function create(Request $request)
    {
        $request->request->add([
            'user_id' => auth()->user()->id,
        ]);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'price' => 'required|numeric',
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

            event::create($data);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ], 200);
        }
    }
    public function edit(Request $request, string $id)
    {
        $event = event::find($id);

        if (is_null($event)) {
            return response()->json([
                'code' => 201,
                'message' => 'Event not found',
                'data' => null
            ], 201);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'price' => 'required|numeric',
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

            $event->update($data);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ], 200);
        }
    }

    public function destroy($id)
    {
        $event = event::find($id)->delete();

        if (is_null($event)) {
            return response()->json([
                'code' => 201,
                'message' => 'Event not found',
                'data' => null
            ], 201);
        }
        else 
        {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => null
            ], 200);
        }
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

    public function show_ticket(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validation->fails())
        {
            return response()->json([
                'code' => 422,
                'message' => 'Validation Error',
                'errors' => $validation->errors()
            ], 422);
        }

        $number_phone = $request->phone;

        $ticket = event_register::where('phone', $number_phone)->first();

        if (is_null($ticket))
        {
            return response()->json([
                'code' => 201,
                'message' => 'Ticket not found',
                'data' => null
            ], 201);
        }
        else
        {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $ticket->ticket_number
            ], 200);
        }
    }
}