<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style>
        html {
            font-family:DejaVu Sans; sans-serif;
        }
    </style>
</head>
<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td><b>Show Name</b></td>
                <td><b>Series</b></td>
                <td><b>Lead Actor</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{$invoice->invoice_number}}
                </td>
                <td>
                    {{$invoice->first_name}}
                </td>
                <td>
                    {{$invoice->last_name}}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
