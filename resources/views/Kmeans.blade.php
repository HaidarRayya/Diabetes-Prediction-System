<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kmeans</title>
    <style>
        :root {
            --fun-green: #181a19a1;
            --eden: #a6acaa;
        }

        body {

            font-family: "Work Sans", sans-serif;
            background-color: #494745;
        }

        .form {
            margin: 200px auto auto auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            border: 2px solid black;
        }

        .flex {
            display: flex;
            width: 100%;
            gap: 6px;
        }

        .form label {
            position: relative;
        }

        .form label .input {
            margin-bottom: 6px;
            width: 89%;
            padding: 10px 10px 20px 10px;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }

        .form label .input+span {
            position: absolute;
            left: 10px;
            top: 15px;
            color: grey;
            font-size: 13.9px;
            cursor: text;
            transition: 0.3s ease;
        }

        .form label .input:focus+span,
        .form label .input:valid+span {
            background-color: white;
            top: -6px;
            font-size: 0.7em;
            font-weight: 600;
        }

        .form label .input:valid+span {
            color: rgb(25, 31, 25);
        }

        .submit {
            border: none;
            outline: none;
            background-color: var(--fun-green);
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            transform: 0.3s ease;
        }

        .submit:hover {
            background-color: var(--eden);
        }
    </style>

</head>

<body>
    <form class="form" action="/Kmeans" method="post">
        @csrf
        <h2 class="wlcome">Enter the Number of Clusters </h2>
        <label>
            <input name="clusters" required="" placeholder="" type="text" class="input">
            <span>Number Of Clusters</span>
        </label>
        <button class="submit" id="submit">send</button>
    </form>
</body>

</html>