<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        if(is_null($user)) {
            return response([
                'message' => 'User Not Authenticated',
                'user' => null
            ], 401);
        }
        
        // if($request->has('img_url') && !empty($request['img_url'])){
        //     $file = base64_decode($request['img_url']);
        //     $imageName = uniqid() . '.png';
        //     $filePath = 'images/' . $imageName;
            
        //     if (Storage::disk('public')->put($filePath, $file)){
        //         $request['img_url'] = Storage::disk('public')->url($filePath);
        //     } else {
        //         return response(['message' => 'Gagal upload gambar'], 409);
        //     }
        // }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore($user)],
            'password' => 'required',
            'phone_number' => 'required|numeric|digits_between:1,13|regex:(08)',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $updateData['password'] = bcrypt($request->password);
        
        $user->name = $updateData['name'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        $user->phone_number = $updateData['phone_number'];
        $user->img_url = $updateData['img_url'];

        if ($user->save()) {
            return response([
                'message' => 'Update User Success',
                'user' => $user
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'user' => null,
        ], 400);
    }
}
