<script type="text/javascript">
    $(document).ready(function() {
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

    function cloneService() {
        var new_service_html = $('#new_service_inputs').children(':lt(3)').clone();
        $('<br/>').prependTo('#new_service_inputs');
        $('<br/>').prependTo('#new_service_inputs');
        new_service_html.prependTo('#new_service_inputs');
    }

    function cloneComponent() {
        var new_component_html = $('#new_component_inputs').children(':lt(3)').clone();
        $('<br/>').prependTo('#new_component_inputs');
        $('<br/>').prependTo('#new_component_inputs');
        new_component_html.prependTo('#new_component_inputs');
    }
</script>

<span>
    <p>Ierīces dati:</p>
    <select name="device_type_id">
        @foreach($device_types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
        @endforeach
    </select>
    <input size="60" type="text" name="name" placeholder="Nosaukums*" value="{{old('name')}}"/>
    <input size="60" type="text" name="additions" placeholder="Komplektācija" value="{{old('additions')}}"/>
</span>
<span>
    <p>Problēmas apraksts:</p>
    <input type="text" name="problem" placeholder="Problēma*" size="80" value="{{old('problem')}}"/>
    <input type="text" name="note" placeholder="Piezīmes" size="60" value="{{old('note')}}"/>
</span>
<span class="device_work_list">
    <span>
        <p>Paredzamie darbi:</p>
        <select id="service_category_id" name="service_category_id" onchange="selected(this.value)">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </span>
    <span>
        <table id="services_table">
            @foreach($services as $service)
                <tr><td id="{{$service->service_category_id}}"><input type="checkbox" name="services[]" value="{{$service->id}}"></td><td>{{$service->description}}</td><td><b>{{$service->price}}</b></td></tr>
            @endforeach
        </table>
    </span>
</span>
<span id="new_service">
    <br/>
    <span id="new_service_inputs">
        <select id="service_category_id" name="new_service_category_id[]">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        <input type="text" name="new_service_description[]" placeholder="Papildus darbs" size="50"/>
        <input type="text" name="new_service_price[]" placeholder="Cena"/>
    </span>
    <button type="button" onClick="cloneService()">+</button>
</span>
<span id="new_component">
    <p>Komponenšu maiņa, iepriekš sarunāts ar klientu:</p>
    <span id="new_component_inputs">
        <input type="text" name="new_component_name[]" placeholder="Komponente" size="50"/>
        <input type="text" name="new_component_price[]" placeholder="Cena"/>
    </span>
    <button type="button" onClick="cloneComponent()">+</button>
</span>
