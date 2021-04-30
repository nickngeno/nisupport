<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Validator;
use Auth;

class SubscriberController extends Controller
{
   public function subscribe(Request $request){
       $validator = Validator::make($request->all(), [
           'tier' => ['required','string',],
           'subscribeTo' => ['required','string',],

       ]);
       if ($validator->fails()) {
           return response()->json(['message' => 'Validation Error']);
       }
       $subscriber = new Subscriber();
       $subscriber->tier = $request->tier;
       $subscriber->subscribeTo =$request->subscribeTo;
       $subscriber->subscribeBy = Auth::guard('api')->user()->id;
       $subscriber-> save();
       return response()->json([
           'message' => 'Subscriber successfully added',
           'data' => $subscriber
       ], 201);

}
}
