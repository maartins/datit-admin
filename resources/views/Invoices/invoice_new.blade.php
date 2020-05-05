@extends('main')

@section('title', 'Klienti/' . substr($invoice->client->first_name . ' ' . $invoice->client->last_name, 0, 50) . '/Jauns rēķins/' . $invoice->invoice_number)

@section('content')
    @if($invoice->client->client_type == 'person')
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

    <form action="../../invoices/new" method="post">
        {{csrf_field()}}
        <div>
            <span class="radio-toolbar">
                <p>Klients:</p>
                @if($invoice->client->client_type == 'person')
                    <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)" disabled/><label for="company_radio">Juridiskais k.</label>
                    <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)" checked disabled/><label for="person_radio">Privātais k.</label>
                @else
                    <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)" checked disabled/><label for="company_radio">Juridiskais k.</label>
                    <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)" disabled/><label for="person_radio">Privātais k.</label>
                @endif
            </span>
            <span>
                <p>Klienta dati:</p>
                <span id="company">
                    @if($invoice->client->client_type == 'person')
                        <input type="text" name="company_name" placeholder="Uzņēmums" readonly/>
                    @else
                        <input type="text" name="company_name" placeholder="Uzņēmums" value="{{$invoice->client->company_name}}" readonly/>
                    @endif
                    </br>
                    </br>
                </span>
                <input type="text" name="first_name" placeholder="Vārds" value="{{$invoice->client->first_name}}" readonly/>
                <input type="text" name="last_name" placeholder="Uzvārds" value="{{$invoice->client->last_name}}" readonly/>
                <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$invoice->client->phone_number}}" readonly/>
                <input size="60" type="text" name="address" placeholder="Adrese" value="{{$invoice->client->address}}" readonly/>
            </span>
        </div>

        <div>
             <span>
                <p>Ierīces dati:</p>
                <select name="device_type_id">
                    @foreach($invoice->device_types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <input size="60" type="text" name="device_name" placeholder="Nosaukums"/>
                <input size="60" type="text" name="device_addition" placeholder="Komplektācija"/>
            </span>
            <span>
                <p>Problēmas apraksts:</p>
                <input type="text" name="device_problem" placeholder="Problēma" size="80"/>
                <input type="text" name="device_note" placeholder="Piezīmes" size="60"/>
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
                <button type="submit" name="action" value="new_device">+ Papildus iekārta</button>
            </span>
        </div>

        @foreach($invoice->devices as $device)
            <div class="device_work_list">
                <span>
                    <p>Ierīce:</p>
                    @foreach($device->types as $type)
                        @if($device->selected == $type->id)
                            <input type="text" name="device_type_names[]" placeholder="Tips" value="{{$type->name}}" readonly/>
                            <input type="text" name="device_type_ids[]" placeholder="Tips" value="{{$type->id}}" hidden/>
                        @endif
                    @endforeach
                    <input type="text" name="device_names[]" placeholder="Nosaukums" value="{{$device->name}}" readonly/>
                    <input type="text" name="device_additions[]" placeholder="Komplektācija" value="{{$device->additions}}" readonly/>
                    <input type="text" name="device_problems[]" placeholder="Problēma" value="{{$device->problem}}" readonly/>
                    <input type="text" name="device_notes[]" placeholder="Piezīme" value="{{$device->notes}}" readonly/>
                </span>
                <p>Veicamie darbi:</p>
                <table>
                    @foreach($device->services_aviable as $service)
                        <tr><td><input type="checkbox" name="{{$device->name}}_services[]" value="{{$service->id}}"></td><td>{{$service->description}}</td><td><b>{{$service->price}}</b></td></tr>
                    @endforeach
                </table>
            </div>
        @endforeach

        <div>
            <span>
                <button class="ok-button" type="submit" name="action" value="new">Izveidot rēķinu</button>
                <button type="submit" name="action" value="back">Atpakaļ</button>
            </span>
        </div>

        <input name="invoice_id"  value="{{$invoice->id}}" type="hidden">
        <input name="client_id"  value="{{$invoice->client_id}}" type="hidden">
    </form>
@endsection