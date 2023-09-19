<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{

    //admin can create new client

    public function store(StoreClientRequest $request){

        $request['password'] = Hash::make($request['password']);

        $client = Client::query()->create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
        ]);

        return response()->json($client, Response::HTTP_CREATED);

    }


    //admin can list all clients

    public function index(){

        $clients=Client::all();

        return response()->json($clients,Response::HTTP_OK);

    }
    //admin can show specific client

    public function show(Client $client){

        return response()->json($client,Response::HTTP_OK);

    }
//    admin can update his profile info

    public function update(UpdateClientRequest $request , Client $client){

        $request['password'] = Hash::make($request['password']);

        $client->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
        ]);

        return response()->json($client, Response::HTTP_CREATED);
    }

    //admin can delete client
    public function destroy(Client $client){

        $client->delete();

       return response()->json('client deleted successfully',Response::HTTP_OK);

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'phone_number' => ['required'],
            'password' => ['required','min:8']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $client = Client::where('phone_number', $request->phone_number)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            throw new AuthenticationException();

        }
        $token =  $client->createToken('personal Access Token')->plainTextToken;

        $data["client"] = $client;
        $data["tokenType"] = 'Bearer';
        $data["access_token"] = $token;

        return response()->json($data, Response::HTTP_OK);

    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return response()->json("logged out", Response::HTTP_OK);

    }


}
