@extends('main')

@section('title', 'Pakalpojumi/' . substr($service->description, 0, 50))

@section('content')
        <form action="/services/update/{{$service->id}}" method="post">
            <div>
                <span>
                <p>Pakalopjuma dati:</p>
                <select name="service_category_id">
                    @foreach($categories as $category)
                        @if($service->category->id == $category->id)
                            <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                </select>
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
