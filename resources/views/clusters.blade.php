<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            margin: 150px;
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
            width: 100%;
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
    </style>
</head>

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Cluster Number</th>
                    <th>Patients</th>
                </tr>
            </thead>
            <tbody>

                @foreach($clusters as $key =>$cluster )
                <tr>
                    <td>{{ "Cluster" .$key +1}}</td>
                    <td>
                        <form action="/patientCluster" method="post">
                            @csrf
                            <input type="hidden" name="patients" value="{{ json_encode($cluster) }}">
                            <input type="submit" value="Show Patients" class="btn">
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

</html>