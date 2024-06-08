<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {

            font-family: "Work Sans", sans-serif;
            background-color: #494745;
        }

        .patient {
            margin-top: 16px;
            margin-left: 51px;
            display: flex;
            align-items: center;
            width: 300px;
            max-width: 650px;
            padding: 29px 19px 24px 15px;
            background: #ffffff;
            border-radius: 24px;
        }

        .patient p {
            color: rgb(0 0 0 / 70%);
        }

        @media (max-width: 740px) {
            .card {
                flex-direction: column;
                text-align: center;
                margin: 14px auto;
                padding-left: 50px;
                padding-right: 50px;
                width: fit-content;
            }
        }

        .patients {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        #patient {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            color: white;

            text-align: center;
        }
    </style>
</head>

<body>
    <h1>The Patient Diagnosis</h1>
    <section id="patient">
        <div class="patient">
            <div>
                <p>Age: {{ $patient->age }}</p>
                <p>Hypertension:{{ $patient->hypertension ? "yes": "no" }} </p>
                <p>Heart Disease:{{ $patient->heart_disease ? "yes": "no"}} </p>
                <p>BMI :{{ $patient->bmi }}</p>
                <p>HbA1c Level :{{ $patient->HbA1c_level }}</p>
                <p>Blood Glucose Level: {{ $patient->blood_glucose_level }}</p>
                <h3>Diabetes: {{ $patient->diabetes ? "yes": "no" }}</h3>
            </div>
        </div>
    </section>
    <hr>
    <section>
        <h1>Diagnosis of similar patients </h1>
        <div class="patients">
            @foreach($patients as $patient)
            <div class="patient">
                <div>
                    <p>Age: {{ $patient->age }}</p>
                    <p>Hypertension:{{ $patient->hypertension ? "yes": "no" }} </p>
                    <p>Heart Disease:{{ $patient->heart_disease ? "yes": "no"}} </p>
                    <p>BMI :{{ $patient->bmi }}</p>
                    <p>HbA1c Level :{{ $patient->HbA1c_level }}</p>
                    <p>Blood Glucose Level: {{ $patient->blood_glucose_level }}</p>
                    <h3>Diabetes: {{ $patient->diabetes ? "yes": "no"}}</h3>
                </div>
            </div>
            @endforeach
    </section>
</body>

</html>