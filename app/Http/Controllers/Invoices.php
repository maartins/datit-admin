<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\Invoice;
use App\Service;
use Codedge\Fpdf\Facades\Fpdf;
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

    public function add($client_id) {
        $client = Client::findOrFail($client_id);
        $client->devices = Device::where('client_id', '=', $client_id)->get();
        $client->services_aviable = Service::all();
        return view('invoice_new', ['client' => $client]);
    }

    public function new($client_id) {
        $invoice = new Invoice();
        $invoice->client_id = $client_id;
        $invoice->save();

        $client = Client::find($client_id);
        $client->invoice_count = Invoices::getInvoiceCount($client_id);
        $client->save();

        return redirect('/clients');
    }

    public function view($id) {
        $invoice = Invoice::findOrFail($id);
        $invoice = Invoices::setupInvoice($invoice);

        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 18);
        Fpdf::Cell(50, 25, 'Datit');
        Fpdf::SetFont('Courier','', 14);
        Fpdf::SetXY(10, 40);
        Fpdf::Cell(100, 25, $invoice->first_name . ' ' . $invoice->last_name);
        Fpdf::SetXY(10, 50);
        Fpdf::Cell(50, 25, $invoice->phone_number);
        Fpdf::SetXY(150, 40);
        Fpdf::Cell(30, 25, 'Nummurs: ');
        Fpdf::Cell(30, 25, $invoice->invoice_number);
        Fpdf::SetXY(10, 80);
        Fpdf::Cell(30, 25,  'Ierices: ');
        foreach($invoice->devices as $device) {
            Fpdf::Cell(30, 25, $device->name);
        }

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

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
        $devices = Device::where('client_id', '=', $invoice->client_id)->get();
        $invoice->devices = $devices;
        return $invoice;
    }

    private function getInvoiceCount($client_id) {
        return Invoice::where('client_id', '=', $client_id)->count();
    }
}
