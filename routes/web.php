<?php
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.home');
});
Route::resource('doctors', DoctorController::class);
