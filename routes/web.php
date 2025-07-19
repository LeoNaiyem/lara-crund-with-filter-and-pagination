<?php
use App\Http\Controllers\FieldController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.home');
});

Route::resource('doctors', App\Http\Controllers\DoctorController::class);
Route::resource('designations', App\Http\Controllers\DesignationController::class);
Route::resource('cattle', App\Http\Controllers\CattleController::class);
Route::resource('fields', FieldController::class);
Route::resource('patients', App\Http\Controllers\PatientController::class);