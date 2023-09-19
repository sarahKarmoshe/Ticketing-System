<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\s;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        $services=Service::all();

        return response()->json($services,Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StoreServiceRequest $request)
    {
        $service=Service::query()->create([
            'title'=>$request->title,
            'price'=>$request->price ,
            'category_id' =>$request->category_id
        ]);

        return response()->json($service,Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Service $service)
    {
        return response()->json($service, Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update([
            'title'=>$request->title,
            'price'=>$request->price ,
            'category_id' =>$request->category_id
        ]);

        return response()->json($service, Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json('service deleted successfully',Response::HTTP_OK);

    }
}
