@extends('main')

@section('title', 'Jauns pasūtījums')

@section('content')
    <form action="/work/new" method="post">
        <div>
            @include('Clients.client_form')
        </div>
        <div>
            @include('Devices.device_form')
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