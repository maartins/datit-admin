<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\Invoice;
use App\InvoiceClientDevice;
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

        return view('Invoices.invoices', ['invoices' => $invoices]);
    }

    public function add($client_id) {
        $client = Client::findOrFail($client_id);
        $client->devices = Device::where('client_id', '=', $client_id)->get();
        $client->services_aviable = Service::all();
        return view('Invoices.invoice_new', ['client' => $client]);
    }

    public function new(Request $request, $client_id) {
        switch ($request->input('action')) {
            case 'new':
                $invoice = new Invoice();
                $invoice->client_id = $client_id;
                $invoice->save();

                $client = Client::find($client_id);
                $client->invoice_count += 1;
                $client->save();

                $devices = Device::where('client_id', '=', $client_id)->get();
                foreach ($devices as $device) {
                    $icd = new InvoiceClientDevice();
                    $icd->invoice_id = $invoice->id;
                    $icd->client_id = $client->id;
                    $icd->device_id = $device->id;
                    $icd->save();
                }

                return redirect('/clients');
            case 'back':
                return redirect('/clients');
        }
    }

    public function view($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice = Invoices::setupInvoice($invoice);

        Invoices::setupPDF($invoice);

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

        return view('Invoices.invoice_view', ['invoice' => $invoice]);
    }

    public function viewClient($client_id, $invoice_id = null) {
        $invoices = null;

        if ($invoice_id == null) {
            $invoices = Invoice::sortable()->where('client_id', '=', $client_id)->paginate(15);
        } else {
            $invoices = Invoice::sortable()->where('id', '=', $invoice_id)->paginate(15);
        }

        if ($invoices->count() > 1) {
            foreach ($invoices as $invoice) {
                $invoice = Invoices::setupInvoice($invoice);
            }

            return view('Clients.client_invoices', ['invoices' => $invoices]);
        }

        $invoice = $invoices->first();
        $invoice = Invoices::setupInvoice($invoice);

        Invoices::setupPDF($invoice);

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

        return view('Clients.client_invoice_view', ['invoice' => $invoice]);
    }

    public function delete($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        $client = Client::find($invoice->client_id);
        $client->invoice_count -= 1;
        $client->save();
        $invoice->delete();

        return back();
    }

    private function setupInvoice($invoice) {
        $invoice->invoice_number = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $client = Client::where('id', '=', $invoice->client_id)->first();
        $invoice->first_name = $client->first_name;
        $invoice->last_name = $client->last_name;
        $invoice->phone_number = $client->phone_number;
        $icd = InvoiceClientDevice::where('client_id', '=', $client->id)->where('invoice_id', '=', $invoice->id)->get();
        foreach ($icd as $list) {
            $devices = Device::find($list->device_id);
        }
        $invoice->devices = $devices;
        return $invoice;
    }

    private function setupPDF($invoice) {
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
    }
}
