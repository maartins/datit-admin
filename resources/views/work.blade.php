@extends('main')

@section('title', 'Jauns pasūtījums')

@section('content')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#company").hide();

            var selected_service_category = $("#service_category_id").children("option:selected").val();

            var rows = $('#services_table tr').hide();
            rows.filter(function () {
                return $.trim($(this).find('td').attr('id')) == selected_service_category
            }).show();
        });

        function selected(value) {
            var rows = $('#services_table tr').hide();
            rows.filter(function () {
                return $.trim($(this).find('td').attr('id')) == value
            }).show();
        }
    </script>
    
    <form action="/work/new" method="post">
        <div>
            @include('Clients.client_form')
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
            <span>
                <p>Komponenšu maiņa, iepriekš sarunāts ar klientu:</p>
                <input type="text" name="new_service" placeholder="Komponente" size="50"/>
                <input type="text" name="new_service" placeholder="Cena"/>
                <button>Pievienot</button>
            </span>
        </div>
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

        <div>
            <span>
                <button class="ok-button" type="submit" name="action" value="new-and-print">Izveidot un printēt pasūtījumu</button>
                <button type="submit" name="action" value="new">Izveidot pasūtījumu</button>
            </span>
        </div>
    </form>
@endsection