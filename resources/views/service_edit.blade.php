@extends('main')

@section('title', 'Pakalpojumi/' . substr($service->description, 0, 50))

@section('content')
    <div>
        <p>Pakalopjuma dati:</p>
        <form action="/services/update/{{$service->id}}" method="post">
            <input size="80" type="text" name="description" placeholder="Vārds" value="{{$service->description}}"/>
            <input type="text" name="price" placeholder="Telefona nr." value="{{$service->price}}"/>
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
        <form action="../../services">
            <button>Atpakaļ</button>
        </form>
    </div>
@endsection