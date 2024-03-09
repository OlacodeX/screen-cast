<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function recordVideo()
    {
        return view('record-video');
    }

    public function saveVideo(Request $request)
    {
        $path = $request->file('video')->store('videos','s3');

        return response()->json([
            'success' => true,
        ]);
    }

}
