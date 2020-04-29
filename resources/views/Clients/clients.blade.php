@extends('main')

@section('title', 'Klienti')

@section('content')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#company").hide();
        });

        function show(value){
            if (value == "person") {
                $("#company").hide();
            } else {
                $("#company").show();
            }
        }
    </script>

    <div>
        <form action="/clients/new" method="post">
            <span class="radio-toolbar">
                <p>Jauns Klients:</p>
                <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)"/><label for="company_radio">Juridiskais k.</label>
                <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)" checked/><label for="person_radio">Privātais k.</label>
            </span>
            <span>
                <p>Klienta dati:</p>
                <span id="company">
                    <input type="text" name="company_name" placeholder="Uzņēmums"/>
                    </br>
                    </br>
                </span>
                <input type="text" name="name" placeholder="Vārds Uzvārds"/>
                <input type="text" name="phone_number" placeholder="Telefona nr."/>
                <input type="text" name="address" placeholder="Adrese" size="60"/>
            </span>
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
                <th>@sortablelink('address', 'Adrese')</th>
                <th>@sortablelink('client_type', 'Tips')</th>
                <th>@sortablelink('company_name', 'Uzņēmuma nosaukums')</th>
                <th>@sortablelink('invoice_count', 'Rēķins/i')</th>
                <th>@sortablelink('created_at', 'Izveidots')</th>
                <th>@sortablelink('updated_at', 'Atjaunots')</th>
            </tr>
            @foreach($clients as $client)
                <tr>
                    @if(isset($client->first_name))
                        <td>{{$client->first_name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->last_name))
                        <td>{{$client->last_name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->phone_number))
                        <td>{{$client->phone_number}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->address))
                        <td>{{$client->address}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->client_type))
                        @if($client->client_type == "person")
                            <td>Privāta</td>
                        @else
                            <td>Juridiska</td>
                        @endif
                    @else
                        <td/>
                    @endif
                    @if(isset($client->company_name))
                        <td>{{$client->company_name}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->invoice_count))
                        <td>{{$client->invoice_count}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->created_at))
                        <td>{{$client->created_at->format('d/m/Y')}}</td>
                    @else
                        <td/>
                    @endif
                    @if(isset($client->updated_at))
                        <td>{{$client->updated_at->format('d/m/Y')}}</td>
                    @else
                        <td/>
                    @endif
                    @if($client->invoice_count > 0)
                        <td><button onclick="window.location.href='invoices/view_client/{{$client->id}}';">Apskatīt rēķinus</button></td>
                    @else
                        <td><button disabled>Apskatīt rēķinus</button></td>
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