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
            $invoice = Invoices::setupInvoice($invoice);
        }

        return view('invoices', ['invoices' => $invoices]);
    }

    public function new($id) {
        $invoice = new Invoice();
        $invoice->client_id = $id;
        $invoice->save();

        $client = Client::find($id);
        $client->invoice_count = Invoices::getInvoiceCount($id);
        $client->save();

        return redirect('/clients');
    }

    public function view($id) {
        $invoice = Invoice::findOrFail($id);
        $invoice = Invoices::setupInvoice($invoice);
        return view('invoice_view', ['invoice' => $invoice]);
    }

    public function delete($id) {
        $invoice = Invoice::findOrFail($id);
        $client = Client::find($invoice->client_id);
        $client->invoice_count = Invoices::getInvoiceCount($invoice->client_id);
        $client->save();
        $invoice->delete();

        return redirect('/invoices');
    }

    private function setupInvoice($invoice) {
        $invoice->invoice_number = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $client = Client::where('id', '=', $invoice->client_id)->first();
        $invoice->first_name = $client->first_name;
        $invoice->last_name = $client->last_name;
        $invoice->phone_number = $client->phone_number;
        return $invoice;
    }

    private function getInvoiceCount($client_id) {
        return Invoice::where('client_id', '=', $client_id)->count();
    }
}
