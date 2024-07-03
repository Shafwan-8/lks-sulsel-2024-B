<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $data = post::all();
        
        foreach ($data as $key => $value) {
            $user = User::find($value->user_id);
            $category = categories::find($value->category_id);
            $data[$key]->user = $user->name;
            $data[$key]->category = $category->name;
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = post::find($id);

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
                'data' => $data
            ]);
        }
    }
}
