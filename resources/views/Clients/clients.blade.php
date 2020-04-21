@extends('main')

@section('title', 'Klienti')

@section('content')
    <div>
        <p>Jauns klients:</p>
        <form action="/clients/new" method="post">
            <input type="text" name="first_name" placeholder="Vārds"/>
            <input type="text" name="last_name" placeholder="Uzvārds"/>
            <input type="text" name="phone_number" placeholder="Telefona nr."/>
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
                <th>@sortablelink('first_name', 'Vārds')</th>
                <th>@sortablelink('last_name', 'Uzvārds')</th>
                <th>@sortablelink('phone_number', 'Telefona nr.')</th>
                <th>@sortablelink('invoice_count', 'Rēķins/i')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($clients as $client)
                <tr>
                    @if(isset($client->first_name))
                        <td>{{$client->first_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($client->last_name))
                        <td>{{$client->last_name}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($client->phone_number))
                        <td>{{$client->phone_number}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($client->invoice_count))
                        <td>{{$client->invoice_count}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($client->created_at))
                        <td>{{$client->created_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if(isset($client->updated_at))
                        <td>{{$client->updated_at->format('d/m/Y')}}</td>
                    @else
                        <td>Trūkst</td>
                    @endif
                    @if($client->invoice_count > 0)
                        @if($client->invoice_count == 1)
                            <td><button onclick="window.location.href='invoices/view_client/{{$client->id}}';">Apskatīt rēķinu</button></td>
                        @else
                            <td><button onclick="window.location.href='invoices/view_client/{{$client->id}}';">Apskatīt rēķinus</button></td>
                        @endif
                    @else
                        <td><button disabled>Apskatīt rēķinu</button></td>
                    @endif
                    <td><button onclick="window.location.href='invoices/add/{{$client->id}}';">Izveidot rēķinu</button></td>
                    <td><button onclick="window.location.href='clients/edit/{{$client->id}}';">Rediģēt klienta datus</button></td>
                    <td><button class="bad-button" onclick="window.location.href='clients/delete/{{$client->id}}';">Dzēst klientu</button></td>
                </tr>
            @endforeach
        </table>
        <span>{{$clients->render()}}</span>
    </div>
@endsection