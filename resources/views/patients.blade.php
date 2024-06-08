<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        .container {
            margin: 50px 50px 10px 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .btn {
            margin-left: 30px;
            text-decoration: none;
            border-radius: 25px;
            border: 1px solid black;
            padding: 5px;
            background-color: rgba(56, 51, 51, 0.753);
            color: white;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .pag {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Age</th>
                    <th>Hypertension</th>
                    <th>Heart Disease</th>
                    <th>BMI</th>
                    <th>HbA1c Level</th>
                    <th>Blood Glucose Level</th>
                </tr>
            </thead>
            <tbody>
                @php
                $x=1;
                @endphp
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $x++ }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->hypertension ? "yes": "no"}}</td>
                    <td>{{ $patient->heart_disease ? "yes": "no"}}</td>
                    <td>{{ $patient->bmi }}</td>
                    <td>{{ $patient->HbA1c_level }}</td>
                    <td>{{ $patient->blood_glucose_level }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>

</html>