@extends('main')

@section('title', 'Klienti/' . substr($invoice->client->first_name . ' ' . $invoice->client->last_name, 0, 50) . '/Jauns rēķins')

@section('content')
    <form action="../../invoices/new" method="post">
        <div>
            @include('Clients.client_form')
        </div>
        <div>
            @include('Devices.device_form')
        </div>
        {{csrf_field()}}
        @if(count($errors))
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <span>
                <button class="ok-button" type="submit" name="action" value="new">Izveidot rēķinu</button>
                <button type="submit" name="action" value="back">Atpakaļ</button>
            </span>
        </div>

        <input name="client_id"  value="{{$invoice->client_id}}" type="hidden">
    </form>
@endsection