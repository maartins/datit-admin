@extends('main')

@section('title', 'Klienti/' . substr($client->first_name . ' ' . $client->last_name, 0, 50))

@section('content')
    @if($client->client_type == 'person')
        <script type="text/javascript">
            $(document).ready(function() {
                $("#company").hide();
            });
        </script>
    @else
        <script type="text/javascript">
            $(document).ready(function() {
                $("#company").show();
            });
        </script>
    @endif
    <script type="text/javascript">
        function show(value){
            if (value == "person") {
                $("#company").hide();
            } else {
                $("#company").show();
            }
        }
    </script>

    <form action="/clients/update/{{$client->id}}" method="post">
        <div>
            <span class="radio-toolbar">
                <p>Klients:</p>
                @if($client->client_type == 'person')
                    <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)"/><label for="company_radio">Juridiskais k.</label>
                    <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)" checked/><label for="person_radio">Privātais k.</label>
                @else
                    <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)" checked/><label for="company_radio">Juridiskais k.</label>
                    <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)"/><label for="person_radio">Privātais k.</label>
                @endif
            </span>
            <span>
                <p>Klienta dati:</p>
                <span id="company">
                    @if($client->client_type == 'person')
                        <input type="text" name="company_name" placeholder="Uzņēmums"/>
                    @else
                        <input type="text" name="company_name" placeholder="Uzņēmums" value="{{$client->company_name}}"/>
                    @endif
                    </br>
                    </br>
                </span>
                <input type="text" name="name" placeholder="Vārds Uzvārds" value="{{$client->first_name . (!empty($client->last_name) ? ' ' . $client->last_name : '')}}"/>
                <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$client->phone_number}}"/>
                <input type="text" name="address" placeholder="Adrese" size="60" value="{{$client->address}}"/>
            </span>
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
            <span>
                <button class="ok-button" type="submit" name="action" value="update">Atjaunot</button>
                <button type="submit" name="action" value="back">Atpakaļ</button>
            </span>
        </div>
    </form>
@endsection