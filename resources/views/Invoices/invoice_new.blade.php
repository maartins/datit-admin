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
                <input type="text" name="name" placeholder="Vārds Uzvārds" value="{{$invoice->client->first_name . ' ' . $invoice->client->last_name}}" readonly/>
                <input type="text" name="phone_number" placeholder="Telefona nr." value="{{$invoice->client->phone_number}}" readonly/>
                <input size="60" type="text" name="address" placeholder="Adrese" value="{{$invoice->client->address}}" readonly/>
            </span>
        </div>

        <div>
             <span>
                <p>Ierīces dati:</p>
                <select name="device_type">
                    @foreach($invoice->device_types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <input size="60" type="text" name="device_name" placeholder="Nosaukums"/>
                <input size="60" type="text" name="device_addition" placeholder="Komplektācija"/>
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
            <span>
                <button type="submit" name="action" value="new_device">+ Papildus iekārta</button>
            </span>
        </div>

        @foreach($invoice->devices as $device)
            <div class="device_work_list">
                <span>
                    <p>Ierīce:</p>
                    <input type="text" name="device_types[]" placeholder="Tips" value="{{$device->type_name}}" readonly/>
                    <input type="text" name="device_names[]" placeholder="Nosaukums" value="{{$device->name}}" readonly/>
                    <input type="text" name="device_additions[]" placeholder="Komplektācija" value="{{$device->additions}}" readonly/>
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