<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    public function subscriptionTo(){
        return $this->belongsTo(User::class,'subscribeTo','id');
    }
    public function userSubscriber(){
        return $this->belongsTo(User::class,'','subscriberId');
    }
}
