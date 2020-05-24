@extends('main')

@section('title', 'Pakalpojumi')

@section('content')
    <div>
        <p>Jauns pakalpojums:</p>
        <form action="/services/new" method="post">
            <select name="service_category_id">
                @foreach($services->service_categories as $categories)
                    <option value="{{$categories->id}}">{{$categories->name}}</option>
                @endforeach
            </select>
            <input size="80" type="text" name="description" placeholder="Apraksts"/>
            <input type="text" name="price" placeholder="Cena"/>
            {{csrf_field()}}
            <button type="submit">Pievienot</button>
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
    </div>

    <div class="table">
        <table>
            <tr>
                <th>@sortablelink('service_category_name', 'Kategorija')</th>
                <th>@sortablelink('description', 'Apraksts')</th>
                <th>@sortablelink('price', 'Cena')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($services as $service)
                <tr>
                    @if(isset($service->service_category_name))
                        <td>{{$service->service_category_name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($service->description))
                        <td>{{$service->description}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($service->price))
                        <td>{{$service->price}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($service->created_at))
                        <td>{{$service->created_at->format('d/m/Y')}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($service->updated_at))
                        <td>{{$service->updated_at->format('d/m/Y')}}</td>
                    @else
                        <td/>
                    @endif
                    <td><button onclick="window.location.href='services/edit/{{$service->id}}';">Rediģēt</button></td>
                    <td><button class="bad-button" onclick="window.location.href='services/delete/{{$service->id}}';">Dzēst</button></td>
                </tr>
            @endforeach
        </table>
        <span>{{$services->render()}}</span>
    </div>
@endsection
