@extends('main')

@section('title', 'Ierīces')

@section('content')
    <div class="table">
        <table>
            <tr>
                <th>@sortablelink('type', 'Tips')</th>
                <th>@sortablelink('name', 'Nosaukums')</th>
                <th>@sortablelink('additions', 'Komplektācija')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($devices as $device)
                <tr>
                    @if(isset($device->type_name))
                        <td>{{$device->type_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->name))
                        <td>{{$device->name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->additions))
                        <td>{{$device->additions}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->problem))
                        <td>{{$device->problem}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->note))
                        <td>{{$device->note}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->created_at))
                        <td>{{$device->created_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($device->updated_at))
                        <td>{{$device->updated_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    <td><button onclick="window.location.href='devices/edit/{{$device->id}}';">Rediģēt ierīces datus</button></td>
                    <td><button class="bad-button" onclick="window.location.href='devices/delete/{{$device->id}}';">Dzēst ierīci</button></td>
                </tr>
            @endforeach
        </table>
        <span>{{$devices->render()}}</span>
    </div>
@endsection