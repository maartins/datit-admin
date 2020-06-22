@extends('main')

@section('title', 'Ierīces/' . substr($device->name, 0, 50))

@section('content')
        <form action="/devices/update/{{$device->id}}" method="post">
            {{csrf_field()}}
            <div>
                <span>
                    <p>Ierīces dati:</p>
                    <select name="device_type_id">
                        @foreach($device_types as $type)
                            @if($device->type->id == $type->id)
                                <option value="{{$type->id}}" selected>{{$type->name}}</option>
                            @else
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <input size="60" type="text" name="name" placeholder="Nosaukums" value="{{$device->name}}"/>
                    <input size="60" type="text" name="additions" placeholder="Komplektācija" value="{{$device->additions}}"/>
                </span>
                <span>
                    <p>Problēmas apraksts:</p>
                    <input type="text" name="problem" placeholder="Problēma" size="80" value="{{$device->problem}}"/>
                    <input type="text" name="note" placeholder="Piezīmes" size="60" value="{{$device->note}}"/>
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
