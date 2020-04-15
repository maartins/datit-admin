@extends('main')

@section('title', 'Ierīces/' . substr($device->name, 0, 50))

@section('content')
    <div>
        <p>Ierīces dati:</p>
        <form action="/devices/update/{{$device->id}}" method="post">
            <input size="80" type="text" name="name" placeholder="Nosaukums" value="{{$device->name}}"/>
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
        <form action="../../devices">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection