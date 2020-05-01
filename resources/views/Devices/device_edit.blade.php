@extends('main')

@section('title', 'Ierīces/' . substr($device->name, 0, 50))

@section('content')
        <form action="/devices/update/{{$device->id}}" method="post">
            <div>
                <span>
                    <p>Ierīces dati:</p>
                    <select name="device_type">
                        @foreach($device->types as $type)
                            @if($device->selected == $type->id)
                                <option value="{{$type->id}}" selected>{{$type->name}}</option>
                            @else
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <input size="60" type="text" name="name" placeholder="Nosaukums" value="{{$device->name}}"/>
                    <input size="60" type="text" name="additions" placeholder="Komplektācija" value="{{$device->additions}}"/>
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
                </span>
            </div>
            <div>
                <span>
                    <button class="ok-button" type="submit" name="action" value="update">Atjaunot</button>
                    <button type="submit" name="action" value="back">Atpakaļ</button>
                </span>
            </div>
        </form>
@endsection