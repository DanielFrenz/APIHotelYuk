<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        if (count($hotels) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $hotels
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if(!is_null($hotel)) {
            return response([
                'message' => 'Retrieve Hotel Success',
                'data' => $hotel
            ], 200);
        }

        return response([
            'message' => 'Hotel Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_hotel' => 'required|unique:hotels',
            'score' => 'required|numeric|min:0|max:5',
            'lokasi' => 'required',
            'alamat' => 'required',
            'img_url' => 'required',
            'latitude' => 'required',
            'longtitude' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $hotel = Hotel::create($storeData);
        return response([
            'message' => 'Add Hotel Success',
            'data' => $hotel
        ], 200);
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if(is_null($hotel)) {
            return response([
                'message' => 'Hotel Not Found',
                'data' => null
            ], 404);
        }

        if($hotel->delete()) {
            return response([
                'message' => 'Delete Hotel Success',
                'data' => $hotel
            ], 200);
        }

        return response([
            'message' => 'Delete Hotel Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        if(is_null($hotel)) {
            return response([
                'message' => 'Hotel Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_hotel' => ['required', Rule::unique('hotels')->ignore($course)],
            'score' => 'required|numeric|min:0|max:5',
            'lokasi' => 'required',
            'alamat' => 'required',
            'img_url' => 'required',
            'latitude' => 'required',
            'longtitude' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
           
        $hotels->nama_hotel = $updateData['nama_hotel'];
        $hotels->score = $updateData['score'];
        $hotels->lokasi = $updateData['lokasi'];
        $hotels->alamat = $updateData['alamat'];
        $hotels->img_url = $updateData['img_url'];
        $hotels->latitude = $updateData['latitude'];
        $hotels->longtitude = $updateData['longtitude'];

        if ($hotel->save()) {
            return response([
                'message' => 'Update Hotel Success',
                'data' => $hotel
            ], 200);
        }
        return response([
            'message' => 'Update Hotel Failed',
            'data' => null,
        ], 400);
    }
}
