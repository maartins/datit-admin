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
                <th>@sortablelink('type', 'Tips')</th>
                <th>@sortablelink('name', 'Nosaukums')</th>
                <th>@sortablelink('additions', 'Komplektācija')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($invoice->devices as $device)
                <tr>
                    @if(isset($device->type_name))
                        <td>{{$device->type_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->name))
                        <td>{{$device->name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->additions))
                        <td>{{$device->additions}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->problem))
                        <td>{{$device->problem}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->note))
                        <td>{{$device->note}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->created_at))
                        <td>{{$device->created_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->updated_at))
                        <td>{{$device->updated_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    <td><button onclick="window.location.href='../../devices/edit/{{$device->id}}';">Rediģēt ierīces datus</button></td>
                    <td><button class="bad-button" onclick="window.location.href='../../devices/delete/{{$device->id}}';">Dzēst ierīci</button></td>
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        <table>
            <tr>
                <th>@sortablelink('service_category_name', 'Kategorija')</th>
                <th>@sortablelink('description', 'Apraksts')</th>
                <th>@sortablelink('price', 'Cena')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($invoice->devices as $device)
                @foreach($device->services as $service)
                    <tr>
                        @if(isset($service->service_category_name))
                            <td>{{$service->service_category_name}}</td>
                        @else
                            <td>Trūkst</td>
                        @endif
                        @if(isset($service->description))
                            <td>{{$service->description}}</td>
                        @else
                            <td>Trūkst</td>
                        @endif
                        @if(isset($service->price))
                            <td>{{$service->price}}</td>
                        @else
                            <td>Trūkst</td>
                        @endif
                        @if(isset($service->created_at))
                            <td>{{$service->created_at->format('d/m/Y')}}</td>
                        @else
                            <td>Trūkst</td>
                        @endif
                        @if(isset($service->updated_at))
                            <td>{{$service->updated_at->format('d/m/Y')}}</td>
                        @else
                            <td>Trūkst</td>
                        @endif
                        <td><button onclick="window.location.href='../../services/edit/{{$service->id}}';">Rediģēt</button></td>
                        <td><button class="bad-button" onclick="window.location.href='../../services/delete/{{$service->id}}';">Dzēst</button></td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>

    <div>
        <object data="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf" width="80%" height="600ex">
            <embed src="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf"/>
        </object>
    </div>

    <div>
        <form action="{{url()->previous()}}">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection