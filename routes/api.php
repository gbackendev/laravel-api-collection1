<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\PatientController;

// OPEN ROUTES
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

// AUTH ROUTER
Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);

    // PATIENT Routes
    Route::get('patient', [PatientController::class, "index"]);
    // DOCTOR Routes
    // APPOINTMENT Routes
    // MEDICAL RECORDS Routes
    // SPECIALITY Routes
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
