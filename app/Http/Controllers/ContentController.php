<?php

namespace App\Http\Controllers;

use App\Models\content;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;

class ContentController extends Controller
{
    //
public function addContent(Request $request)
{
    $validator = Validator::make($request->all(), [
        'contentName' => ['nullable','string',],
        'description' => ['required','string',],
        'thumbNailPic'=>'nullable','mimes:mp4,mov,ogg,qt | max:20000',
        'tier' => ['required','string',],
    ]);
    if ($validator->fails()) {
        return response()->json(['message' => 'Validation Error']);
    }
    $videoUpload = null;
    if ($files = $request->file('thumbNailPic')) {
        $destinationPath = 'Contents/'; // upload path
        $videoUpload = date('YmdHis') . "." . $files->getClientOriginalExtension();
        $files->move($destinationPath, $videoUpload);
    }
//    return Auth::guard('api')->user();
    $content = new content();
    $content->contentName = $request-> contentName;
    $content->description = $request-> description;
    $content->thumbNailPic = $videoUpload;
    $content->tier = $request-> tier;
    $content->postedBy = Auth::guard('api')->user()->id;
    $content->save();
    return response()->json([
        'message' => 'content successfully added',
        'data' => $content
    ], 201);

}
    public function showContent(){
        return User::where('category','=','artist')->get();
    }
    public function showContentByPostedBy($postedBy){
        return content::where('postedBy',$postedBy)->get();
    }


}
