<?php

namespace App\Http\Controllers;

use App\Models\content;
use Illuminate\Http\Request;
use Validator;

class ContentController extends Controller
{
    //
public function addContent(Request $request)
{
    $validator = Validator::make($request->all(), [
        'contentName' => ['nullable','string',],
        'description' => ['required','string',],
        'thumbNailPic'=>['nullable',],
        'tier' => ['required','string',],
    ]);
    if ($validator->fails()) {
        return response()->json(['message' => 'Validation Error']);
    }
    $videoUpload = null;
    if ($files = $request->file('upload')) {
        $destinationPath = 'Contents/'; // upload path
        $videoUpload = date('YmdHis') . "." . $files->getClientOriginalExtension();
        $files->move($destinationPath, $videoUpload);
    }
    $content = new content();
    $content->contentName = $request-> contentName;
    $content->description = $request-> description;
    $content->thumbNailPic = $request-> thumbNailPic;
    $content->tier = $request-> tier;
    $content->postedBy = Auth::guard('postedBy')->user()->id;
    $content->save();
    return response()->json([
        'message' => 'content successfully added',
        'data' => $content
    ], 201);

}

}
