<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/scan', function () {
    return view('scan');
});
Route::post('/save-code', [ProductController::class, 'updatedCode']);