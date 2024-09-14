<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee History PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2>Employee History - {{ $employee->first_name }} {{ $employee->last_name }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date And Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($access_logs as $log)
            <tr>
                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $log->successful ? 'Successful' : 'Failed' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
