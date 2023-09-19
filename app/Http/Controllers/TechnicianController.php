<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Http\Requests\StoreTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => ['required','numeric'],

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $technicians = Technician::query()
            ->simplePaginate(
                3,
                ['*'],
                'page',
                $request->page
            );

        return response()->json($technicians, Response::HTTP_OK);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTechnicianRequest $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StoreTechnicianRequest $request)
    {
        $technician=Technician::query()->create([
            'name' => $request->name,
            'hour_cost' => $request->hour_cost,

        ]);

        return response()->json($technician,Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Technician $technician
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Technician $technician)
    {
        return response()->json($technician,Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTechnicianRequest $request
     * @param \App\Models\Technician $technician
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(UpdateTechnicianRequest $request, Technician $technician)
    {
        $technician->update([
            'name' => $request->name,
            'hour_cost' => $request->hour_cost,

        ]);

        return response()->json($technician,Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Technician $technician
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();

        return response()->json('technician deleted successfully',Response::HTTP_OK);

    }
}
