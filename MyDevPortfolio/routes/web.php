<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/about', [DemoController::class,'Index']);
// Route::get('/about', [DemoController::class, 'Index'])->name('about.page');


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index');
    Route::get('/contact', 'ContactMethode')->name('contact.page');
    // Route::post('/example2', 'method2');
});
