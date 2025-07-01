<?php
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.home');
});

Route::resource('doctors', App\Http\Controllers\DoctorController::class);
Route::resource('designations', App\Http\Controllers\DesignationController::class);
Route::resource('cattle', App\Http\Controllers\CattleController::class);