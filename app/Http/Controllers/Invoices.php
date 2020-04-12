<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use Illuminate\Http\Request;

class Invoices extends Controller
{
    public function index() {
        $invoices = Invoice::sortable()->paginate(2);
        
        foreach ($invoices as $invoice) {
            $invoice->invoice_number = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
            $client = Client::where('id', '=', $invoice->user_id)->first();
            $invoice->first_name = $client->first_name;
            $invoice->last_name = $client->last_name;
            $invoice->phone_number = $client->phone_number;
        }

        return view('invoices', ['invoices' => $invoices]);
    }

    public function new($id) {
        $invoice = new Invoice();
        $invoice->user_id = $id;
        $invoice->save();

        return redirect('/clients');
    }
}
