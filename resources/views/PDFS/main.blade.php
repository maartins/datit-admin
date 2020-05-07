<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style>
        html {
            font-family:DejaVu Sans; sans-serif;
        }

        h1, h2 {
            padding: 0; 
            margin: 0;
        }

        td { 
            padding-right: 2mm;
        }
    </style>
</head>
<body>
    <h1 style="position: absolute; top: 0mm;">Datit</h1>
    <h3 style="position: absolute; top: 2mm; left: 75%;">Nr. {{$invoice->invoice_number}}</h3>
    <table style="position: absolute; top: 30mm; left: 64.5%;">
        <tbody>
            <tr>
                <td style="margin-lef">Klients:</td>
                <td>
                    {{$invoice->client->first_name}} {{$invoice->client->last_name}}
                </td>
            </tr>
            <tr>
                <td/>
                <td>
                    {{$invoice->client->address}}
                </td>
            </tr>
            <tr>
                <td/>
                <td>
                    {{$invoice->client->company_name}}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
