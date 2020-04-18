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
        $invoices = Invoice::sortable()->paginate(15);
        
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
        $client->invoice_count += 1;
        $client->save();

        return redirect('/clients');
    }

    public function view($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
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
            Fpdf::SetY(Fpdf::GetY() + 6);
            Fpdf::Cell(30, 25, $device->name);
        }

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

        return view('invoice_view', ['invoice' => $invoice]);
    }

    public function viewClient($client_id) {
        $invoices = Invoice::sortable()->where('client_id', '=', $client_id)->paginate(15);

        if ($invoices->count() > 1) {
            foreach ($invoices as $invoice) {
                $invoice = Invoices::setupInvoice($invoice);
            }

            return view('client_invoices', ['invoices' => $invoices]);
        }

        $invoice = $invoices->first();
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
            Fpdf::SetY(Fpdf::GetY() + 6);
            Fpdf::Cell(30, 25, $device->name);
        }

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

        return view('client_invoice_view', ['invoice' => $invoice]);
    }

    public function delete($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        $client = Client::find($invoice->client_id);
        $client->invoice_count -= 1;
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
}
