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

Route::get('/data', function () {
    $row = 1;
    $row = 1;
    $x1 = 0;
    $x2 = 0;
    $rowsDiabetes = [];
    $rowsUnDiabetes = [];
    $y = 0;

    if (($handle1 = fopen("C:\Users\Haidar\Desktop\Knn\diabetes.csv", "r")) !== FALSE) {
        while (($row = fgetcsv($handle1)) !== false && $x1 <= 15000) {
            $rowsDiabetes[] = $row;
            $x1++;
        }
    }
    fclose($handle1);
    $headers = array_shift($rowsDiabetes);
    $arrayDiabetes = [];
    foreach ($rowsDiabetes as $row) {
        $arrayDiabetes[] = array_combine($headers, $row);
    }

    $patientsDiabetes = [];
    foreach ($arrayDiabetes as $x) {
        $patient = new Patient($x);
        array_push($patientsDiabetes, $patient);
    }
    //dd($patientsDiabetes);
    //--
    if (($handle2 = fopen("C:\Users\Haidar\Desktop\Knn\undiabetes.csv", "r")) !== FALSE) {
        while (($row = fgetcsv($handle2)) !== false && $x2 <= 15000) {
            $rowsUnDiabetes[] = $row;
            $x2++;
        }
    }
    fclose($handle2);
    $headers = array_shift($rowsUnDiabetes);
    $arrayUnDiabetes = [];
    foreach ($rowsUnDiabetes as $row) {
        $arrayUnDiabetes[] = array_combine($headers, $row);
    }

    $patientsUnDiabetes = [];
    foreach ($arrayUnDiabetes as $x) {
        $patient = new Patient($x);
        array_push($patientsUnDiabetes, $patient);
    }
    // dd($patientsUnDiabetes);
    $patients = [...$patientsUnDiabetes, ...$patientsDiabetes];
    for ($i = 0; $i < 1500; $i++) {
        shuffle($patients);
    }
    foreach ($patients as $p) {
        Patient::create([
            'age' => $p->age,
            'hypertension' =>  $p->hypertension,
            'heart_disease' => $p->heart_disease,
            'bmi' => $p->bmi,
            'HbA1c_level' => $p->HbA1c_level,
            'blood_glucose_level' => $p->blood_glucose_level,
            'diabetes' => $p->diabetes
        ]);
    }

    return view('welcome',);
});
