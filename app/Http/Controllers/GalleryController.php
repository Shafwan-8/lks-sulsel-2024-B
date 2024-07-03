<?php

namespace App\Http\Controllers;

use App\Models\gallery;
use App\Models\User;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $data = gallery::all();

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
        $data = gallery::find($id);

        if (is_null($data))
        {
            return response()->json([
                'code' => 201,
                'message' => 'failed',
                'data' => null,
            ], 201);
        }
        else
        {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data,
            ], 200);
        }
    }
}
