<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable =[ 'title' , 'price' , 'category_id' ];

    protected $with = ['category'];

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function ticket(){
        return $this->hasMany(Ticket::class , 'service_id');
    }

}
