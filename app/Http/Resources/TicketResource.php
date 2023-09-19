<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total_working_hours' => $this->total_working_hours,
            'total_cost' => $this->total_cost,
            'work_report' => $this->work_report,
            'work_completion_date' => $this->work_completion_date,
            'created_date'=>$this->created_at,
            'service' => $this->service->only(['id', 'price', 'title']),
            'status' => $this->status->only(['id', 'title']),
            'priority' => $this->priority->only(['id', 'title', 'value']),
            'technicians' => $this->technician->map(function ($technician) {
                return [
                    'id' => $technician->id,
                    'name' => $technician->name,
                    'hour_cost' => $technician->hour_cost,
                ];
            }),
        ];
    }
}
