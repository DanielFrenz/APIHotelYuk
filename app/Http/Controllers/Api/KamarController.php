<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Hotel;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index($hotelId)
    {
        $hotel = Hotel::find($hotelId);
        if(!is_null($hotel)) {
            $kamars = $hotel->kamars;
            if(is_null($kamars)){
                return response([
                    'message' => 'Tidak ada Kamar',
                    'data' => null
                ], 400);
            }else{
                return response([
                    'message' => 'Retrieve Kamar Success',
                    'data' => $kamars
                ], 200);
            }
        }else{
            return response([
                'message' => 'Hotel Not Found',
                'data' => null
            ], 404);    
        }
    }

    public function show($hotelId, $id)
    {
        $hotel = Hotel::find($hotelId);
        if(!is_null($hotel)) {
            $kamar = Kamar::find($id);

            if(!is_null($kamar)) {
                return response([
                    'message' => 'Retrieve Kamar Success',
                    'data' => $kamar
                ], 200);
            }

            return response([
                'message' => 'Kamar Not Found',
                'data' => null
            ], 404);
        }else{
            return response([
                'message' => 'Hotel Not Found',
                'data' => null
            ], 404);    
        }
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_kamar' => 'required',
            'hotel_id' => 'required|numeric',
            'img_url' => 'required',
            'harga' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $kamar = Kamar::create($storeData);
        return response([
            'message' => 'Add Kamar Success',
            'data' => $kamar
        ], 200);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);

        if(is_null($kamar)) {
            return response([
                'message' => 'Kamar Not Found',
                'data' => null
            ], 404);
        }

        if($kamar->delete()) {
            return response([
                'message' => 'Delete Kamar Success',
                'data' => $kamar
            ], 200);
        }

        return response([
            'message' => 'Delete Kamar Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::find($id);
        if(is_null($kamar)) {
            return response([
                'message' => 'Kamar Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_kamar' => 'required',
            'hotel_id' => 'required|numeric',
            'img_url' => 'required',
            'harga' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $kamar->nama_kamar = $updateData['nama_kamar'];
        $kamar->hotel_id = $updateData['hotel_id'];
        $kamar->img_url = $updateData['img_url'];
        $kamar->harga = $updateData['harga'];

        if ($kamar->save()) {
            return response([
                'message' => 'Update Kamar Success',
                'data' => $kamar
            ], 200);
        }
        return response([
            'message' => 'Update Kamar Failed',
            'data' => null,
        ], 400);
    }
}
