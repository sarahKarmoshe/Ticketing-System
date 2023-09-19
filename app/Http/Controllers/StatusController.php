<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\s;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        $status=Status::all();

        return response()->json($status,Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StoreStatusRequest $request)
    {
        $status=Status::query()->create([
            'title'=>$request->title,
        ]);

        return response()->json($status,Response::HTTP_CREATED);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Status $status)
    {
        return response()->json($status, Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
         $status->update([
        'title'=>$request->title,
    ]);

        return response()->json($status,Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return response()->json('status deleted successfully',Response::HTTP_OK);

    }
}
