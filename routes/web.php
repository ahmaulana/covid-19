<?php

use App\Preprocessing\PreprocessingService;
use Illuminate\Support\Facades\Route;
use Thujohn\Twitter\Facades\Twitter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $tweets = Twitter::getSearch(['q' => 'COVID -RT', 'tweet_mode' => 'extended', 'lang' => 'id', 'count' => 10, 'format' => 'array']);    
    dd($tweets);
});
