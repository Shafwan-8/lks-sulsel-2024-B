<?php

namespace App\Http\Controllers;

use App\Models\event;
use Illuminate\Http\Request;

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
}
