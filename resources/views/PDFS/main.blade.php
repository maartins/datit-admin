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
    <h3 style="position: absolute; top: 2mm; left: 80%;">Nr. {{$invoice->invoice_number}}</h3>
    <div style="position: absolute; top: 14mm; border-top: 0.3mm solid black; font-size: 6pt;">Tirgus iela 7, Ventspils, LV-3601</div>
    <table style="position: absolute; top: 28mm; left: 65%; border-left: 0.3mm solid black; border-top: 0.3mm solid black; padding-left:2mm;">
        <tbody>
            <tr>
                <td>
                    {{$invoice->client->first_name}} {{$invoice->client->last_name}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$invoice->client->phone_number}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$invoice->client->address}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$invoice->client->company_name}}
                </td>
            </tr>
        </tbody>
    </table>
    <table style="position: absolute; top: 90mm; width:100%; border-top: 0.3mm solid black; padding:1mm;">
        <tbody>
            @foreach($invoice->devices as $device)
                <tr>
                    @if(isset($device->type_name))
                        <td>{{$device->type_name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($device->name))
                        <td>{{$device->name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($device->additions))
                        <td>{{$device->additions}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($device->problem))
                        <td>{{$device->problem}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($device->note))
                        <td>{{$device->note}}</td>
                    @else
                        <td/>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
