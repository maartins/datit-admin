@extends('main')

@section('title', 'Klienti/' . substr($client->first_name . ' ' . $client->last_name, 0, 50))

@section('content')
    <div>
        <p>Klienta dati:</p>
        <form action="/clients/update/{{$client->id}}" method="post">
            <input type="text" name="first_name" placeholder="Vārds" value="{{$client->first_name}}"/>
            <input type="text" name="last_name" placeholder="Uzvārds" value="{{$client->last_name}}"/>
            <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$client->phone_number}}"/>
            {{csrf_field()}}
            <button type="submit">Atjaunot</button>
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
        <form action="../../clients">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection