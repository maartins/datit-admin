@extends('main')

@section('title', 'Klienti/' . substr($invoice->first_name . ' ' . $invoice->last_name, 0, 50) . '/Jauns rēķins/' . $invoice->invoice_number)

@section('content')
    <form action="../../invoices/new" method="post">
        <div>
            <p>Klienta dati:</p>
            <input type="text" name="first_name" placeholder="Vārds" value="{{$invoice->first_name}}" readonly/>
            <input type="text" name="last_name" placeholder="Uzvārds" value="{{$invoice->last_name}}" readonly/>
            <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$invoice->phone_number}}" readonly/>
        </div>

        <div>
            <input type="text" name="name" placeholder="Nosaukums"/>
            {{csrf_field()}}
            <button type="submit" name="action" value="new_device">Izveidot ierīci</button>
            @if(count($errors))
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @foreach($invoice->devices as $device)
            <div class="device_work_list">
                <p>Ierīce: <b><input type="text" name="devices[]" placeholder="Nosaukums" value="{{$device->name}}" readonly/></b></p>
                <p>Veicamie darbi:</p>
                <table>
                    @foreach($device->services_aviable as $service)
                        <tr><td><input type="checkbox" name="{{$device->name}}_services[]" value="{{$service->id}}"></td><td>{{$service->description}}</td><td><b>{{$service->price}}</b></td></tr>
                    @endforeach
                </table>
            </div>
        @endforeach

        <div>
            <button class="ok-button" type="submit" name="action" value="new">Izveidot rēķinu</button>
            <button type="submit" name="action" value="back">Atpakaļ</button>
        </div>

        <input name="invoice_id"  value="{{$invoice->id}}" type="hidden">
        <input name="client_id"  value="{{$invoice->client_id}}" type="hidden">
    </form>
@endsection