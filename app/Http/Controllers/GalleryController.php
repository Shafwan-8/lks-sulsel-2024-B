<?php

namespace App\Http\Controllers;

use App\Models\gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $tervalidasi = Validator::make($request->all(), [
            'name' => 'required',
            'user_id' => 'required',
            'description' => 'required',
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
            gallery::create($tervalidasi);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $tervalidasi,
            ], 200);
        } 

    }

    public function edit(Request $request, string $id)
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

        $tervalidasi = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
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
            $data->update($tervalidasi);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $tervalidasi,
            ], 200);
        }
    }

    public function delete(string $id)
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
            $data->delete();

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => null,
            ], 200);
        }
    }
}
