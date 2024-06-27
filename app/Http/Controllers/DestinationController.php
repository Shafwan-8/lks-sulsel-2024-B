<?php

namespace App\Http\Controllers;

use App\Models\destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $data = destination::all();

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ], 200);

    }

    public function show($id)
    {
        $data = destination::where('id', $id)->first();

        if ($data)
        {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data,
            ], 200);
        }
        else
        {
            return response()->json([
                'code' => 201,
                'message' => 'data not found',
                'data' => null,
            ], 201);
        }
    }
}
