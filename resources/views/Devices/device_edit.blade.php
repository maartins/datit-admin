@extends('main')

@section('title', 'Ierīces/' . substr($device->name, 0, 50))

@section('content')
        <form action="/devices/update/{{$device->id}}" method="post">
            <div>
                <p>Ierīces dati:</p>
                <input size="80" type="text" name="name" placeholder="Nosaukums" value="{{$device->name}}"/>
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