<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $user = User::where('id', $data->user_id)->first();
        $category = categories::where('id', $data->category_id)->first();
        $data->user = $user->name;
        $data->category = $category->name;

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

    public function create(Request $request)
    {
        $request->request->add([
            'user_id' => auth()->user()->id,
            'status' => rand(1,3),
        ]);

        $tervalidasi = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if ($tervalidasi->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'validation error',
                'data' => $tervalidasi->errors(),
            ], 400);
        }
        else
        {
            $tervalidasi = $tervalidasi->validated();

            $data = post::create($tervalidasi);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data,
            ], 200);
        }
    }

    public function edit(Request $request, string $id)
    {
        $post = post::find($id);

        if (is_null($post))
        {
            return response()->json([
                'code' => 201,
                'message' => 'failed',
                'data' => null,
            ], 201);
        }

        $tervalidasi = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        if ($tervalidasi->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'validation error',
                'data' => $tervalidasi->errors(),
            ], 400);
        }
        else
        {
            $data = $tervalidasi->validated();
            $post->update($data);    

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $post,
            ], 200);
        }

    }

    public function destroy(string $id)
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
            $data->delete();

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => null,
            ], 200);
        }
    }
}
