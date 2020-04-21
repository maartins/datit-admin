@extends('main')

@section('title', 'Klienti/' . substr($client->first_name . ' ' . $client->last_name, 0, 50))

@section('content')
    <form action="/clients/update/{{$client->id}}" method="post">
        <div>
            <p>Klienta dati:</p>
            <input type="text" name="first_name" placeholder="Vārds" value="{{$client->first_name}}"/>
            <input type="text" name="last_name" placeholder="Uzvārds" value="{{$client->last_name}}"/>
            <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$client->phone_number}}"/>
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
        </div>
        <div>
            <button class="ok-button" type="submit" name="action" value="update">Atjaunot</button>
            <button type="submit" name="action" value="back">Atpakaļ</button>
        </div>
    </form>
@endsection