<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'priority_id',
        'service_id',
        'status_id',
        'total_working_hours',
        'total_cost',
        'work_report',
        'work_completion_date',
    ];

    protected $with =['service','status','priority','technician'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function technician(){

        return $this->belongsToMany(Technician::class , 'technicians_tickets');
    }

    public function evaluation(){

        return $this->hasOne(TicketEvaluation::class ,'ticket_id');
    }

}
