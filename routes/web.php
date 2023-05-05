<?php

use App\Jobs\DownloadDataB3Job;
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

    (new DownloadDataB3Job())->handle();
    return("Hello");
                    
});

/* Route::get('scraper', [App\Http\Controllers\ScrapeController::class, 'scraper'])->name('scraper'); */