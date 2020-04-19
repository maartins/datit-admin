@extends('main')

@section('title', 'Pakalpojumi/' . substr($service->description, 0, 50))

@section('content')
        <form action="/services/update/{{$service->id}}" method="post">
            <div>
                <p>Pakalopjuma dati:</p>
                <input size="80" type="text" name="description" placeholder="Vārds" value="{{$service->description}}"/>
                <input type="text" name="price" placeholder="Telefona nr." value="{{$service->price}}"/>
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