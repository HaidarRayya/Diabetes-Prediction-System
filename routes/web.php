<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Models\Patient;

Route::get('/', function () {
    return view('index');
});
Route::get('/Knn', [PatientController::class, 'showKnnPage']);
Route::post('/Knn', [PatientController::class, 'Knn']);
Route::get('/Kmeans', [PatientController::class, 'showKmeansPage']);
Route::post('/Kmeans', [PatientController::class, 'Kmeans']);
Route::post('/patientCluster', [PatientController::class, 'patientCluster']);
