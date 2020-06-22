@extends('main')

@section('title', 'Rēķini/' . $invoice->invoice_number)

@section('content')
    <div>
        <p>Rēķina dati:</p>
        <table>
            <tr>
                <th>Rēķina nr.</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>Telefona nr.</th>
                <th>Adrese</th>
                <th>Tips</th>
                <th>Uzņēmums</th>
                <th>Summa</th>
                <th>Izveidots</th>
            </tr>
            <tr>
                @if(isset($invoice->invoice_number))
                    <td>{{$invoice->invoice_number}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->first_name))
                    <td>{{$invoice->client->first_name}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->last_name))
                    <td>{{$invoice->client->last_name}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->phone_number))
                    <td>{{$invoice->client->phone_number}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->address))
                    <td>{{$invoice->client->address}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->client_type))
                    @if($invoice->client->client_type == "person")
                        <td>Privāta</td>
                    @else
                        <td>Juridiska</td>
                    @endif
                @else
                    <td/>
                @endif
                @if(isset($invoice->client->company_name))
                    <td>{{$invoice->client->company_name}}</td>
                @else
                    <td/>
                @endif
                @if(isset($invoice->total_sum))
                    <td>{{$invoice->total_sum}}</td>
                @else
                    <<td/>
                @endif
                @if(isset($invoice->created_at))
                    <td>{{$invoice->created_at->format('d/m/Y')}}</td>
                @else
                    <td/>
                @endif
            </tr>
        </table>
    </div>

    <div>
        <table>
            <tr>
                <th>Tips</th>
                <th>Nosaukums</th>
                <th>Komplektācija</th>
                <th>Problēmas</th>
                <th>Piezīmes</th>
            </tr>
            @foreach($invoice->devices as $device)
                <tr>
                    @if(isset($device->type->name))
                        <td>{{$device->type->name}}</td>
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
                    <td><button onclick="window.location.href='../../devices/edit/{{$device->id}}';">Rediģēt ierīces datus</button></td>
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        <table>
            <tr>
                <th>Kategorija</th>
                <th>Apraksts</th>
                <th>Cena</th>
            </tr>
            @foreach($invoice->devices as $device)
                @foreach($device->services as $service)
                    <tr>
                        @if(isset($service->category->name))
                            <td>{{$service->category->name}}</td>
                        @else
                            <td/>
                        @endif
                        @if(isset($service->description))
                            <td>{{$service->description}}</td>
                        @else
                            <td/>
                        @endif
                        @if(isset($service->price))
                            <td>{{$service->price}}</td>
                        @else
                            <td/>
                        @endif
                        <td><button onclick="window.location.href='../../services/edit/{{$service->id}}';">Rediģēt</button></td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>

    <div>
        <object id="pdf" data="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf" width="80%" height="600ex">
            <embed src="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf"/>
        </object>
    </div>

    <div>
        <form action="{{url()->previous()}}">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection
