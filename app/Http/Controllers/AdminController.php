<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function signUp(StoreAdminRequest $request){

        $request['password'] = Hash::make($request['password']);

        $admin = Admin::query()->create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
        ]);

        $token =  $admin->createToken('personal Access Token')->plainTextToken;

        $data["admin"] = $admin;
        $data["tokenType"] = 'Bearer';
        $data["token"] = $token;

        return response()->json($data, Response::HTTP_OK);

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'phone_number' => ['required'],
            'password' => ['required','min:8']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $admin = Admin::where('phone_number', $request->phone_number)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw new AuthenticationException();

        }
        $token =  $admin->createToken('personal Access Token')->plainTextToken;

        $data["admin"] = $admin;
        $data["tokenType"] = 'Bearer';
        $data["access_token"] = $token;

        return response()->json($data, Response::HTTP_OK);

    }


    public function logout(){

        auth()->user()->tokens()->delete();

        return response()->json("logged out", Response::HTTP_OK);

    }
}
