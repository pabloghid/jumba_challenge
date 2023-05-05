<?php

use App\Jobs\DownloadDataB3Job;
use App\Services\InsertB3Data;
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

    DownloadDataB3Job::dispatch();

/*     $test = new InsertB3Data();

    $data = $test->read_csv();

    $insert = $test->execute($data); */

    return("Hello");
                    
});

/* Route::get('scraper', [App\Http\Controllers\ScrapeController::class, 'scraper'])->name('scraper'); */