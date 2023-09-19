<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateTicketRequest;
use App\Http\Requests\CompleteTicketRequest;
use App\Http\Requests\EvaluateTicketRequest;
use App\Http\Resources\TicketCollectionResource;
use App\Http\Resources\TicketResource;
use App\Models\Status;
use App\Models\Technician;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Models\TicketEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        if ($request->has('created_at')) {
            $date = $request->created_at;
            $startDate = $date . ' 00:00:00';
            $endDate = $date . ' 23:59:59';
            $tickets = Ticket::query()->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        } else {
            $tickets = Ticket::query()->get();

        }
        $tickets->load('service','priority','status');
        return response()->json(new TicketCollectionResource($tickets) , Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */

    public function show(Ticket $ticket)
    {
        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);
    }

    /**
     * activate the specified resource in storage.
     *
     * @param \App\Http\Requests\ActivateTicketRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */
    public function activate(ActivateTicketRequest $request, Ticket $ticket)
    {
        if($ticket->status->title != 'pending' ){
            return response()->json('can not activate ticket');
        }

        $statusId = Status::where('title', 'active')->pluck('id')->first();

        $price = $ticket->service->price;
        $priorityValue = $ticket->priority->value;
        $techniciansCount = count($request->technicians);

        $hourCosts = Technician::whereIn('id', $request->technicians)->get()->sum('hour_cost');


        $cost = $price + ($techniciansCount * $hourCosts * $priorityValue);

        $ticket->update([
            'total_working_hours' => $request->total_working_hours,
            'total_cost' => $cost,
            'status_id' => $statusId
        ]);

        $ticket->technician()->syncWithoutDetaching($request->technicians);

        $ticket->load('technician');

        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);
    }

    /**
     * complete the specified resource in storage.
     *
     * @param \App\Http\Requests\CompleteTicketRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */
    public function complete(CompleteTicketRequest $request, Ticket $ticket)
    {
        if($ticket->status->title != 'active' ){
            return response()->json('can not complete ticket');
        }

        $statusId = Status::where('title', 'complete')->pluck('id')->first();

        $ticket->update([
            'work_report' => $request->work_report,
            'work_completion_date' => $request->work_completion_date,
            'status_id' => $statusId
        ]);

        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json('ticket deleted successfully', Response::HTTP_OK);

    }


    // client

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function indexClient(Request $request)
    {
        $tickets = Ticket::query()->where('client_id', '=', Auth::guard('clients')->user()->id)->get();

        $tickets->load('service','priority','status');

        return response()->json(new TicketCollectionResource ($tickets) , Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */

    public function showClient(Ticket $ticket)
    {
        if ($ticket->client_id != Auth::guard('clients')->user()->id) {
            return response()->json('UnAuthorized', Response::HTTP_UNAUTHORIZED);
        }
        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketRequest $request
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(StoreTicketRequest $request)
    {
        $statusId = Status::where('title', 'pending')->pluck('id')->first();

        $ticket = Ticket::query()->create([
            'client_id' =>  Auth::guard('clients')->user()->id,
            'priority_id' => $request->priority_id,
            'service_id' => $request->service_id,
            'status_id' => $statusId,
        ]);

        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);
    }


    /**
     * evaluate the specified resource in storage.
     *
     * @param \App\Http\Requests\EvaluateTicketRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\jsonResponse
     */
    public function evaluate(EvaluateTicketRequest $request, Ticket $ticket)
    {
        if($ticket->status->title != 'complete' ){
            return response()->json('can not activate ticket');
        }

        $evaluation = TicketEvaluation::query()->create([
            'ticket_id' => $ticket->id,
            'evaluation_id' => $request->evaluation_id,
            'clients_notes' => $request->clients_notes
        ]);
        $evaluation->load('evaluation') ;
        $evaluationValue = $evaluation->evaluation->value;

        switch ($evaluationValue) {
            case 4:
                $discount = 5;
                break;
            case 3:
                $discount = 15;
                break;
            case 2:
                $discount = 25;
                break;
            case 1:
                $discount = 50;
                break;
            default:
                $discount = 0;
                break;
        }

        $discountAmount = $ticket->total_cost * ($discount / 100);
        $finalCost = $ticket->total_cost - $discountAmount;


        $statusId = Status::where('title', 'done')->pluck('id')->first();

        $ticket->update([
            'status_id' => $statusId,
            'total_cost'=>$finalCost
        ]);


        return response()->json(new TicketResource ($ticket) , Response::HTTP_OK);

    }

}
