<?php

namespace App\Http\Controllers;

use App\Models\destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'code' => 422,
                'message' => 'Validation Error',
                'data' => $tervalidasi->errors(),
            ], 422);
        }
        else 
        {
            $data = $tervalidasi->validated();

            destination::create($data);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ], 200);
        }   
    }

    public function update(Request $request, string $id)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $tervalidasi = Validator::make($request->all(), [
            'name' => '',
            'user_id' => 'required',
            'description' => '', 
        ]);

        $data = destination::where('id', $id)->first();

        if ($tervalidasi->fails()) 
        {
            return response()->json([
                'code' => 422,
                'message' => 'Validation Error',
                'data' => $tervalidasi->errors(),
            ], 422);
        }
        else 
        {
            $data = $tervalidasi->validated();

            destination::where('id', $id)->update($data);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ], 200);
        }   
    }

    public function destroy($id)
    {
        $data = destination::find($id);

        if ($data)
        {
            $data->delete();

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => null,
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
