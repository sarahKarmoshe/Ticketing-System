<?php

namespace App\Http\Controllers;

use App\Models\TicketEvaluation;
use App\Http\Requests\StoreTicketEvaluationRequest;
use App\Http\Requests\UpdateTicketEvaluationRequest;

class TicketEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketEvaluationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketEvaluationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketEvaluation  $ticketEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(TicketEvaluation $ticketEvaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketEvaluationRequest  $request
     * @param  \App\Models\TicketEvaluation  $ticketEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketEvaluationRequest $request, TicketEvaluation $ticketEvaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketEvaluation  $ticketEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketEvaluation $ticketEvaluation)
    {
        //
    }
}
