<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable =[ 'name', 'hour_cost' ];

    public function ticket(){

        return $this->belongsToMany(Ticket::class , 'technicians_tickets');
    }
}
