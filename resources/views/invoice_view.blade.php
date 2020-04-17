@extends('main')

@section('title', 'Rēķini/' . $invoice->invoice_number)

@section('content')
    <div>
        <p>Rēķina dati:</p>
        <table>
            <tr>
                <th>Rēķina nr.</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>Telefona nr.</th>
                <th>Summa</th>
                <th>Izveidots</th>
            </tr>
            <tr>
                @if(isset($invoice->invoice_number))
                    <td>{{$invoice->invoice_number}}</td>
                @else
                    <td>Trūkst</td>
                @endif
                @if(isset($invoice->first_name))
                    <td>{{$invoice->first_name}}</td>
                @else
                    <td>Trūkst</td>
                @endif
                @if(isset($invoice->last_name))
                    <td>{{$invoice->last_name}}</td>
                @else
                    <td>Trūkst</td>
                @endif
                @if(isset($invoice->phone_number))
                    <td>{{$invoice->phone_number}}</td>
                @else
                    <td>Trūkst</td>
                @endif
                @if(isset($invoice->total_sum))
                    <td>{{$invoice->total_sum}}</td>
                @else
                    <td>Trūkst</td>
                @endif
                @if(isset($invoice->created_at))
                    <td>{{$invoice->created_at->format('d/m/Y')}}</td>
                @else
                    <td>Trūkst</td>
                @endif
            </tr>
        </table>
        <form action="../../invoices">
            <button>Atpakaļ</button>
        </form>
    </div>

    <div>
        <object data="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf" width="80%" height="700ex">
            <embed src="data:application/pdf;base64,{{$invoice->pdf}}" type="application/pdf"/>
        </object>
    </div>
@endsection