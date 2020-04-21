@extends('main')

@section('title', 'Klienti/' . substr($client->first_name . ' ' . $client->last_name, 0, 50) . '/Jauns rēķins')

@section('content')
    <div>
        <p>Klienta dati:</p>
        <input type="text" name="first_name" placeholder="Vārds" value="{{$client->first_name}}" disabled/>
        <input type="text" name="last_name" placeholder="Uzvārds" value="{{$client->last_name}}" disabled/>
        <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$client->phone_number}}" disabled/>
    </div>

    <div>
        <form action="../../devices/new/{{$client->id}}">
            <input type="text" name="name" placeholder="Nosaukums"/>
            {{csrf_field()}}
            <button>Izveidot ierīci</button>
            @if(count($errors))
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    @foreach($client->devices as $device)
        <div class="device_work_list">
            <p>Ierīce: <b>{{$device->name}}</b></p>
            <p>Veicamie darbi:</p>
            <table>
                @foreach($client->services_aviable as $service)
                    <tr><td><input type="checkbox" name="checkbox_service" value="{{$service->id}}"></td><td>{{$service->description}}</td><td><b>{{$service->price}}</b></td></tr>
                @endforeach
            </table>
        </div>
    @endforeach

    <div>
        <form action="../../invoices/new/{{$client->id}}">
            <button class="ok-button" type="submit" name="action" value="new">Izveidot rēķinu</button>
            <button type="submit" name="action" value="back">Atpakaļ</button>
        </form>
    </div>
@endsection