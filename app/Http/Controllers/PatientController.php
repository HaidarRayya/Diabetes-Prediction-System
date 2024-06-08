<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function showKnnPage()
    {
        return view('Knn');
    }
    public function Knn(Request $request)
    {
        $request->validate([
            'age' => 'required',
            'hypertension' => 'required',
            'heart_disease' => 'required',
            'bmi' => 'required',
            'HbA1c_level' => 'required',
            'blood_glucose_level' => 'required',
            'numberOfCases' => 'required'
        ]);

        $k = $request->numberOfCases;
        $newPatient = new Patient([
            'age' =>  $request->age,
            'hypertension' => $request->hypertension,
            'heart_disease' => $request->heart_disease,
            'bmi' => $request->bmi,
            'HbA1c_level' => $request->HbA1c_level,
            'blood_glucose_level' => $request->blood_glucose_level,
            'diabetes' => -1
        ]);
        $newPatient = self::MinMaxNormalzationNewPatient($newPatient);

        $patients = Patient::limit(10000)->get();
        $patientsNormalzation = self::MinMaxNormalzationData($patients);
        $patientsWithDist = self::dist($patientsNormalzation, $newPatient);
        $x = self::bubbleSort($patientsWithDist);
        $Kpatinets = array_slice($x, 0, $k);
        $patientDiabetes = 0;
        $patientUnDiabetes = 0;
        $Simlerpatinets = [];
        foreach ($Kpatinets as $patient) {
            if ($patient['patient']->diabetes == 1) {
                $patientDiabetes++;
            } else if ($patient['patient']->diabetes == 0) {
                $patientUnDiabetes++;
            }
            array_push($Simlerpatinets, self::beforNormalzation($patient['patient']));
        }
        ($patientDiabetes >  $patientUnDiabetes) ? $newPatient->diabetes = 1 : $newPatient->diabetes = 0;

        $newPatient = self::beforNormalzation($newPatient);
        Patient::create([
            'age' =>  $newPatient->age,
            'hypertension' => $newPatient->hypertension,
            'heart_disease' => $newPatient->heart_disease,
            'bmi' => $newPatient->bmi,
            'HbA1c_level' => $newPatient->HbA1c_level,
            'blood_glucose_level' => $newPatient->blood_glucose_level,
            'diabetes' => $newPatient->diabetes
        ]);
        return view("patient", ["patient" => $newPatient, 'patients' => $Simlerpatinets]);
    }

    public function beforNormalzation($patient)
    {
        $MinMAx = self::getMinMaxValues();
        $patient->age = (int) ($patient->age * ($MinMAx['maxAge'] - $MinMAx['minAge']) + $MinMAx['minAge']);
        $patient->bmi = $patient->bmi * ($MinMAx['maxBmi'] - $MinMAx['minBmi']) + $MinMAx['minBmi'];
        $patient->HbA1c_level = $patient->HbA1c_level *
            ($MinMAx['maxHbA1c_level'] - $MinMAx['minHbA1c_level']) + $MinMAx['minHbA1c_level'];
        $patient->blood_glucose_level = $patient->blood_glucose_level *
            ($MinMAx['maxBlood_glucose_level'] - $MinMAx['minBlood_glucose_level']) + $MinMAx['minBlood_glucose_level'];

        return  $patient;
    }

    private function dist($patients, Patient $newPatient)
    {
        $patientsWithDist = [];
        $distance = 0;
        foreach ($patients as $patient) {
            $distance = sqrt(pow($patient->age - $newPatient->age, 2)
                + pow($patient->hypertension - $newPatient->hypertension, 2)
                + pow($patient->heart_disease - $newPatient->heart_disease, 2)
                + pow($patient->bmi - $newPatient->bmi, 2)
                + pow($patient->HbA1c_level - $newPatient->agHbA1c_levele, 2)
                + pow($patient->blood_glucose_level - $newPatient->blood_glucose_level, 2));
            array_push($patientsWithDist, array("patient" => $patient, "distance" => $distance));
        }
        return $patientsWithDist;
    }
    private function bubbleSort($patients)
    {
        $n = count($patients);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($patients[$j]['distance'] > $patients[$j + 1]['distance']) {
                    $temp = $patients[$j];
                    $patients[$j] = $patients[$j + 1];
                    $patients[$j + 1] = $temp;
                }
            }
        }
        return $patients;
    }
    private function getMinMaxValues()
    {
        $minAge = Patient::min('age');
        $maxAge = Patient::max('age');
        $minBmi = Patient::min('bmi');
        $maxBmi = Patient::max('bmi');
        $minHbA1c_level = Patient::min('HbA1c_level');
        $maxHbA1c_level = Patient::max('HbA1c_level');
        $minBlood_glucose_level = Patient::min('blood_glucose_level');
        $maxBlood_glucose_level = Patient::max('blood_glucose_level');

        return [
            'minAge' => $minAge,
            'maxAge' => $maxAge,
            'minBmi' => $minBmi,
            'maxBmi' => $maxBmi,
            'minHbA1c_level' => $minHbA1c_level,
            'maxHbA1c_level' => $maxHbA1c_level,
            'minBlood_glucose_level' => $minBlood_glucose_level,
            'maxBlood_glucose_level' => $maxBlood_glucose_level,
        ];
    }
    private function MinMaxNormalzationNewPatient($patient)
    {
        $MinMAx = self::getMinMaxValues();
        $patient->age = ($patient->age - $MinMAx['minAge'])
            / ($MinMAx['maxAge'] - $MinMAx['minAge']);
        $patient->bmi = ($patient->bmi - $MinMAx['minBmi'])
            / ($MinMAx['maxBmi'] - $MinMAx['minBmi']);
        $patient->HbA1c_level = ($patient->HbA1c_level - $MinMAx['minHbA1c_level'])
            / ($MinMAx['maxHbA1c_level'] - $MinMAx['minHbA1c_level']);
        $patient->blood_glucose_level = ($patient->blood_glucose_level - $MinMAx['minBlood_glucose_level'])
            / ($MinMAx['maxBlood_glucose_level'] - $MinMAx['minBlood_glucose_level']);
        return  $patient;
    }
    private function MinMaxNormalzationData($patients)
    {
        $NormalzationData = [];
        $MinMAx = self::getMinMaxValues();

        foreach ($patients as $patient) {
            $patient->age = ($patient->age - $MinMAx['minAge'])
                / ($MinMAx['maxAge'] - $MinMAx['minAge']);
            $patient->bmi = ($patient->bmi - $MinMAx['minBmi'])
                / ($MinMAx['maxBmi'] - $MinMAx['minBmi']);
            $patient->HbA1c_level = ($patient->HbA1c_level - $MinMAx['minHbA1c_level'])
                / ($MinMAx['maxHbA1c_level'] - $MinMAx['minHbA1c_level']);
            $patient->blood_glucose_level = ($patient->blood_glucose_level - $MinMAx['minBlood_glucose_level'])
                / ($MinMAx['maxBlood_glucose_level'] - $MinMAx['minBlood_glucose_level']);
            array_push($NormalzationData, $patient);
        }
        return $NormalzationData;
    }

    public function showKmeansPage()
    {
        return view('Kmeans');
    }

    function search($patients, int $id, int $number)
    {
        foreach ($patients as $p) {
            if ($p->id == $id) {
                $p->cluster = $number;
            }
        }
    }

    private function initializeCenters($patients, $rows, $k)
    {
        $centers = [];
        for ($i1 = 0; $i1 < $k; $i1++) {
            $x1 = rand(0, $rows - 1);
            array_push($centers, $patients[$x1]);
        }
        return  $centers;
    }

    private function CompareTwoCentrs($AllCenters, $NumberOfLoop, $NumberOfClusters): bool
    {
        $centers1 = $AllCenters[$NumberOfLoop - 1];
        $centers2 = $AllCenters[$NumberOfLoop];
        for ($i = 0; $i < $NumberOfClusters; $i++) {
            if (!($centers1[$i] == $centers2[$i])) {
                return true;
            }
        }
        return false;
    }
    public function ClusteringPatients($patients)
    {
        $data = [];
        foreach ($patients as $patient) {
            array_push($data, [$patient->id => $patient->cluster]);
        }
        return $data;
    }
    public function Kmeans(Request $request)
    {
        $NumberOfClusters = $request->clusters;
        $rows = 2000;
        $patients = Patient::where("diabetes", '=', 1)->limit($rows)->get();
        $patients = self::MinMaxNormalzationData($patients);
        $NumberOfLoop = 0;
        $centers = [];
        $stop = false;
        $AllCenters = [];
        $Clusters = [];

        while (!$stop) {
            if ($NumberOfLoop === 0) {
                $centers = self::initializeCenters($patients, $rows, $NumberOfClusters);
                array_push($AllCenters, $centers);
            } else {
                $centers = [];
                for ($c1 = 0; $c1 < $NumberOfClusters; $c1++) {
                    $patient = new Patient([
                        'age' =>  0,
                        'hypertension' =>  0,
                        'heart_disease' => 0,
                        'bmi' => 0,
                        'HbA1c_level' => 0,
                        'blood_glucose_level' => 0,
                        'diabetes' => -1,
                        'cluster' => $c1
                    ]);
                    $num = 1;
                    $age = 0;
                    $hypertension = 0;
                    $heart_disease = 0;
                    $bmi = 0;
                    $HbA1c_level = 0;
                    $blood_glucose_level = 0;
                    foreach ($patients as $p) {
                        if ($p->cluster === $c1) {
                            $num++;
                            $age += $p->age;
                            $hypertension += $p->hypertension;
                            $heart_disease += $p->heart_disease;
                            $bmi += $p->bmi;
                            $HbA1c_level += $p->HbA1c_level;
                            $blood_glucose_level += $p->blood_glucose_level;
                        }
                    }
                    $patient->age = intdiv($age, $num);
                    $patient->hypertension =  intdiv($hypertension, $num);
                    $patient->heart_disease = intdiv($heart_disease, $num);
                    $patient->bmi = (float)$bmi / $num;
                    $patient->HbA1c_level = (float)$HbA1c_level / $num;
                    $patient->blood_glucose_level =  intdiv($blood_glucose_level, $num);

                    array_push($centers, $patient);
                }
                array_push($AllCenters, $centers);
            }

            $centersWithDist = [];
            foreach ($centers as $c) {
                array_push($centersWithDist, self::dist($patients, $c));
            }
            $patientsClusters = [];
            for ($i = 0; $i < count($centersWithDist); $i++) {
                $y = [];
                for ($j = 0; $j < count($centersWithDist[$i]); $j++) {
                    array_push(
                        $y,
                        array(
                            'cluster' => $i,
                            "patient" => $centersWithDist[$i][$j]['patient'],
                            'distance' => $centersWithDist[$i][$j]['distance'],
                        )
                    );
                }
                array_push($patientsClusters, $y);
            }

            $patientK = [];
            for ($i = 0; $i < $rows; $i++) {
                $n = [];
                for ($j = 0; $j < $NumberOfClusters; $j++) {
                    array_push($n, $patientsClusters[$j][$i]);
                }
                array_push($patientK, $n);
            }
            foreach ($patientK as $k) {
                $k = self::bubbleSort($k);

                if ($k[0]['patient']->cluster != $k[0]['cluster']) {
                    self::search($patients, $k[0]['patient']->id, $k[0]['cluster']);
                }
            }
            if ($NumberOfLoop >= 1) {
                $stop = self::CompareTwoCentrs($AllCenters, $NumberOfLoop, $NumberOfClusters);
            }
            $NumberOfLoop++;
        }
        for ($i = 1; $i <= $NumberOfClusters; $i++) {
            array_push($Clusters, []);
        }
        foreach ($patients as $patient) {
            array_push($Clusters[$patient->cluster], self::beforNormalzation($patient));
        }
        return view("clusters", ["clusters" => $Clusters]);
    }
    public function patientCluster(Request $request)
    {
        return view("patients", ["patients" => json_decode($request->patients)]);
    }
}