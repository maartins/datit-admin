@extends('main')

@section('title', 'Jauns pasūtījums')

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

    <form action="">
        {{csrf_field()}}
        <div>
            <span class="radio-toolbar">
                <p>Klients:</p>
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
                <input type="text" name="first_name" placeholder="Vārds"/>
                <input type="text" name="last_name" placeholder="Uzvārds"/>
                <input type="text" name="phone_number" placeholder="Telefona nr."/>
                <input type="text" name="address" placeholder="Adrese" size="60"/>
            </span>
        </div>

        <div>
            <span>
                <p>Iekārta:</p>
                <select name="device_type">
                    <option value="1">Portatīvais</option>
                    <option value="2">Stacianārais</option>
                    <option value="3">LCD monitors</option>
                    <option value="4">Vadības moduļi</option>
                </select>
                <input size="60" type="text" name="name" placeholder="Nosaukums"/>
                <input size="60" type="text" name="additions" placeholder="Komplektācija"/>
            </span>
             <span>
                <p>Problēmas apraksts:</p>
                <input type="text" name="problem" placeholder="Problēma" size="80"/>
                <input type="text" name="notes" placeholder="Piezīmes" size="60"/>
            </span>
            <span class="device_work_list">
                <span>
                    <p>Paredzamie darbi:</p>
                    <select>
                        <option value="1">Dzelži</option>
                        <option value="2">Programmatūra</option>
                        <option value="3">Citi</option>
                    </select>
                </span>
                <span>
                    <table>
                        <tr><td><input type="checkbox" name="s_services" value="1"></td><td>Programmatūra - Pārinstalēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="2"></td><td>Programmatūra - Attārpot</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="3"></td><td>Dzelži - pārlodēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="3"></td><td>Dzelži - pārlodēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="3"></td><td>Dzelži - pārlodēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="4"></td><td>Dzelži - pielīmēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="4"></td><td>Dzelži - pielīmēt</td><td><b>10.00</b></td></tr>
                        <tr><td><input type="checkbox" name="s_services" value="4"></td><td>Dzelži - pielīmēt</td><td><b>10.00</b></td></tr>
                    </table>
                    <input type="text" name="new_service" placeholder="Apraksts" size="50"/>
                    <button>+ Jauns darbs</button>
                </span>
            </span>

            <span>
                <button>+ Papildus iekārta</button>
            </span>
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
            <button>Izveidot rēķinu</button>
        </div>
    <form action="">
@endsection