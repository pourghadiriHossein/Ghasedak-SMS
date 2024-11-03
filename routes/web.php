<?php

use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SMSController::class,'index'])->name('index');
Route::post('/send', [SMSController::class,'send'])->name('send');


