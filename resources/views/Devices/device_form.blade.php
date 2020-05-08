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

    function cloneService() {
        var new_service_html = $('#new_service_inputs').children(':lt(4)').clone();
        new_service_html.prependTo('#new_service_inputs');
    }
</script>

<span>
    <p>Ierīces dati:</p>
    <select name="device_type_id">
        @foreach($invoice->device_types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
        @endforeach
    </select>
    <input size="60" type="text" name="name" placeholder="Nosaukums*"/>
    <input size="60" type="text" name="additions" placeholder="Komplektācija"/>
</span>
<span>
    <p>Problēmas apraksts:</p>
    <input type="text" name="problem" placeholder="Problēma*" size="80"/>
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
    </span>
</span>
<span id="new_service">
    <span id="new_service_inputs">
        <br/>
        <br/>
        <input type="text" name="new_service_description[]" placeholder="Papildus darbs" size="50"/>
        <input type="text" name="new_service_price[]" placeholder="Cena"/>
    </span>
    <button type="button" onClick="cloneService()">+</button>
</span>
<span>
    <p>Komponenšu maiņa, iepriekš sarunāts ar klientu:</p>
    <input type="text" name="component[]" placeholder="Komponente" size="50"/>
    <input type="text" name="component_price[]" placeholder="Cena"/>
    <button type="button">+</button>
</span>