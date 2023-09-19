<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable =[ 'title' , 'value' ];

    public function TicketEvaluation(){
        return $this->hasMany(TicketEvaluation::class,'evaluation_id');
    }
}
