
@if(isset($invoice->client))
    @php ($client_type = $invoice->client->client_type)
@elseif(isset($client))
    @php ($client_type = $client->client_type)
@else
    @php ($client_type = 'person')
@endif

@if($client_type == 'person')
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

@if(isset($invoice->client))
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
                <input type="text" name="company_name" placeholder="Uzņēmums*" readonly/>
                <input type="text" name="compnay_reg" placeholder="Reģistrācijas Nr.*" readonly/>
            @else
                <input type="text" name="company_name" placeholder="Uzņēmums*" value="{{$invoice->client->company_name}}" readonly/>
                <input type="text" name="compnay_reg" placeholder="Reģistrācijas Nr.*" value="{{$invoice->client->compnay_reg}}" readonly/>
            @endif
            </br>
            </br>
        </span>
        <input type="text" name="first_name" placeholder="Vārds*" value="{{$invoice->client->first_name}}" readonly/>
        <input type="text" name="last_name" placeholder="Uzvārds" value="{{$invoice->client->last_name}}" readonly/>
        <input type="text" name="phone_number" placeholder="Telefona nr.*" value="{{$invoice->client->phone_number}}" readonly/>
        <input size="60" type="text" name="address" placeholder="Adrese" value="{{$invoice->client->address}}" readonly/>
    </span>
@elseif(isset($client))
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
                <input type="text" name="company_name" placeholder="Uzņēmums*" />
                <input type="text" name="compnay_reg" placeholder="Reģistrācijas Nr.*" />
            @else
                <input type="text" name="company_name" placeholder="Uzņēmums*" value="{{$client->company_name}}"/>
                <input type="text" name="compnay_reg" placeholder="Reģistrācijas Nr.*" value="{{$client->compnay_reg}}"/>
            @endif
            </br>
            </br>
        </span>
        <input type="text" name="first_name" placeholder="Vārds*" value="{{$client->first_name}}"/>
        <input type="text" name="last_name" placeholder="Uzvārds" value="{{$client->last_name}}"/>
        <input type="text" name="phone_number" placeholder="Telefona nr.*" value="{{$client->phone_number}}"/>
        <input size="60" type="text" name="address" placeholder="Adrese" value="{{$client->address}}"/>
    </span>
@else
    <span class="radio-toolbar">
        <p>Klients:</p>
        <input type="radio" id="company_radio" name="client_type" value="company" onchange="show(this.value)"/><label for="company_radio">Juridiskais k.</label>
        <input type="radio" id="person_radio" name="client_type" value="person" onchange="show(this.value)" checked/><label for="person_radio">Privātais k.</label>
    </span>
    <span>
        <p>Klienta dati:</p>
        <span id="company">
            <input type="text" name="company_name" placeholder="Uzņēmums*" value="{{old('company_name')}}"/>
            <input type="text" name="compnay_reg" placeholder="Reģistrācijas Nr.*" value="{{old('compnay_reg')}}"/>
            </br>
            </br>
        </span>
        <input type="text" name="first_name" placeholder="Vārds*" value="{{old('first_name')}}"/>
        <input type="text" name="last_name" placeholder="Uzvārds" value="{{old('last_name')}}"/>
        <input type="text" name="phone_number" placeholder="Telefona nr.*" value="{{old('phone_number')}}"/>
        <input size="60" type="text" name="address" placeholder="Adrese" value="{{old('address')}}"/>
    </span>
@endif
