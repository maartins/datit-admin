@extends('main')

@section('title', 'Darba panelis')

@section('content')
    <div>
        <p>Klienta dati:</p>
        <input type="text" name="first_name" placeholder="Vārds"/>
        <input type="text" name="last_name" placeholder="Uzvārds"/>
        <input type="text" name="phone_number" placeholder="Telefona nr."/>
    </div>

    <div>
        <form action="">
            <input type="text" name="name" placeholder="Nosaukums"/>
            {{csrf_field()}}
            <button>Izveidot ierīci</button>
            @if(count($errors))
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    <div>
        <form action=".">
            <button>Izveidot rēķinu</button>
        </form>
    </div>
@endsection