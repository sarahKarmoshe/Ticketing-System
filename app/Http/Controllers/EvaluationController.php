<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use Symfony\Component\HttpFoundation\Response;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        $evaluations=Evaluation::query()->get();

        return response()->json($evaluations,Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEvaluationRequest  $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StoreEvaluationRequest $request)
    {
        $evaluation=Evaluation::query()->create([
            'title' => $request->title,
            'value' => $request->value
        ]);

        return response()->json($evaluation , Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Evaluation $evaluation)
    {
        return response()->json($evaluation , Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEvaluationRequest  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $evaluation->update([
            'title' => $request->title,
            'value' => $request->value
        ]);

        return response()->json($evaluation , Response::HTTP_OK);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return response()->json('evaluation deleted successfully' , Response::HTTP_OK);

    }
}
