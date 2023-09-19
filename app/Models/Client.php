<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function ticket(){
        return $this->hasMany(Ticket::class , 'client_id');
    }



}
