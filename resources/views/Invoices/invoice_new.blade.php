@extends('main')

@section('title', 'Klienti/' . substr($invoice->client->first_name . ' ' . $invoice->client->last_name, 0, 50) . '/Jauns rēķins')

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
        $(document).ready(function() {
            var selected_service_category = $("#service_category_id").children("option:selected").val();

            var rows = $('#services_table tr').hide();
            rows.filter(function () {
                return $.trim($(this).find('td').attr('id')) == selected_service_category
            }).show();
        });

        function show(value){
            if (value == "person") {
                $("#company").hide();
            } else {
                $("#company").show();
            }
        }

        function selected(value) {
            $('#services_table tr td input').prop("checked", false);

            var rows = $('#services_table tr').hide();
            rows.filter(function () {
                return $.trim($(this).find('td').attr('id')) == value
            }).show();
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
                <input size="60" type="text" name="name" placeholder="Nosaukums"/>
                <input size="60" type="text" name="additions" placeholder="Komplektācija"/>
            </span>
            <span>
                <p>Problēmas apraksts:</p>
                <input type="text" name="problem" placeholder="Problēma" size="80"/>
                <input type="text" name="note" placeholder="Piezīmes" size="60"/>
            </span>
            <span class="device_work_list">
                <span>
                    <p>Paredzamie darbi:</p>
                    <select id="service_category_id" name="service_category_id" onchange="selected(this.value)">
                        @foreach($invoice->service_categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <table id="services_table">
                        @foreach($invoice->services as $service)
                            <tr><td id="{{$service->service_category_id}}"><input type="checkbox" name="services[]" value="{{$service->id}}"></td><td>{{$service->description}}</td><td><b>{{$service->price}}</b></td></tr>
                        @endforeach
                    </table>
                    <input type="text" name="new_service" placeholder="Papildus darbs" size="50"/>
                    <button>Pievienot</button>
                </span>
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
            <span>
                <button class="ok-button" type="submit" name="action" value="new">Izveidot rēķinu</button>
                <button type="submit" name="action" value="back">Atpakaļ</button>
            </span>
        </div>

        <input name="client_id"  value="{{$invoice->client_id}}" type="hidden">
    </form>
@endsection