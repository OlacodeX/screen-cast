<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RecordVideo extends Component
{
    public $video;
    public function uploadVideo()
    {
        // dd($this->video);
        $video = $this->video;
        $url = $video->store('videos'); // Save the video to storage/app/videos directory
        $contents = Storage::disk('s3')->get($url);
        $file_name = $video->hashName();
        Storage::disk('s3')->put($url, $file_name);
        session()->flash('notify', 'video saved');
        return response()->json(['success' => true]);
    }

    public function render()
    {
        return view('livewire.record-video');
    }
}
