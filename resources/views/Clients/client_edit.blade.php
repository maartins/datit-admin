@extends('main')

@section('title', 'Klienti/' . substr($client->first_name . ' ' . $client->last_name, 0, 50))

@section('content')
    <form action="/clients/update/{{$client->id}}" method="post">
        <div>
            @include('Clients.client_form')
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
            <span>
                <button class="ok-button" type="submit" name="action" value="update">Atjaunot</button>
                <button type="submit" name="action" value="back">Atpakaļ</button>
            </span>
        </div>
    </form>
@endsection