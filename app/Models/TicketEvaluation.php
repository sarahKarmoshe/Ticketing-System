<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'evaluation_id', 'clients_notes'];


    public function ticket(){

        return $this->belongsTo(Ticket::class , 'ticket_id');
    }

    public function evaluation(){

        return $this->belongsTo(Evaluation::class,'evaluation_id');
    }
}
