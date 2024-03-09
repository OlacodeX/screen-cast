<?php

use App\Http\Controllers\VideoController;
use App\Livewire\RecordVideo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/save-video',[VideoController::class, 'saveVideo']);

Route::get('/video-record', RecordVideo::class);
