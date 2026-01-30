<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController; 

Route::post('/register', [RegistrationController::class, 'register']);

