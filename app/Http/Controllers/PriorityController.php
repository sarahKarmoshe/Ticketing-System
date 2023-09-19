<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Http\Requests\StorePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use Symfony\Component\HttpFoundation\Response;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        $priorities=Priority::all();

        return response()->json($priorities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePriorityRequest  $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StorePriorityRequest $request)
    {
        $priority=Priority::query()->create([
            'title' => $request->title,
            'value' => $request->value,
        ]);

        return response()->json($priority,Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Priority $priority)
    {
        return response()->json($priority,Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriorityRequest  $request
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(UpdatePriorityRequest $request, Priority $priority)
    {
        $priority->update([
            'title'=>$request->title,
            'value' => $request->value,

        ]);

        return response()->json($priority,Response::HTTP_OK);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Priority $priority)
    {
        $priority->delete();

        return response()->json('priority deleted successfully',Response::HTTP_OK);

    }
}
