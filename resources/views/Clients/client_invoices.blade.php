@extends('main')

@section('title', 'Klienti/' . substr($invoices[0]->client->first_name . ' ' . $invoices[0]->client->last_name, 0, 50) . '/Rēķini')

@section('content')
    <div class="table">
        <table>
            <tr>
                <th>@sortablelink('invoice_number', 'Rēķina nr.')</th>
                <th>@sortablelink('first_name', 'Vārds')</th>
                <th>@sortablelink('last_name', 'Uzvārds')</th>
                <th>@sortablelink('phone_number', 'Telefona nr.')</th>
                <th>@sortablelink('address', 'Adrese')</th>
                <th>@sortablelink('client_type', 'Tips')</th>
                <th>@sortablelink('company_name', 'Uzņēmums')</th>
                <th>@sortablelink('total_sum', 'Summa')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
            </tr>
            @foreach($invoices as $invoice)
                <tr>
                    @if(isset($invoice->invoice_number))
                        <td>{{$invoice->invoice_number}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($invoice->client->first_name))
                        <td>{{$invoice->client->first_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($invoice->client->last_name))
                        <td>{{$invoice->client->last_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($invoice->client->phone_number))
                        <td>{{$invoice->client->phone_number}}</td>
                    @else
                        <td>Trūkst</td>
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
                        <td>Trūkst</td>
                    @endif
                    @if(isset($invoice->created_at))
                        <td>{{$invoice->created_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    <td><button onclick="window.location.href='../../invoices/view/{{$invoice->id}}';">Apskatīt</button></td>
                    <td><button class="bad-button" onclick="window.location.href='../../invoices/delete/{{$invoice->id}}';">Dzēst</button></td>
                </tr>
            @endforeach
        </table>
        <span>{{$invoices->render()}}</span>
    </div>

    <div>
        <form action="../../clients">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection