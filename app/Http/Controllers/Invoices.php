<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\Invoice;
use App\InvoiceClientDevice;
use App\Service;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Http\Request;

class Invoices extends Controller {

    public function index() {
        $invoices = Invoice::sortable()->paginate(15);
        
        foreach ($invoices as $invoice) {
            $invoice = Invoices::setupInvoice($invoice);
        }

        return view('Invoices.invoices', ['invoices' => $invoices]);
    }

    public function add($client_id) {
        $invoice = null;
        if (!session()->has('invoice')) {
            $invoice = new Invoice();
            $invoice->id = empty(Invoice::latest()->first()->id) ? 1 : Invoice::latest()->first()->id + 1;
            $invoice->client_id = $client_id;
            $invoice = Invoices::setupInvoice($invoice);
            session()->flash('invoice', $invoice);
        } else {
            $invoice = session('invoice');
        }

        return view('Invoices.invoice_new', ['invoice' => $invoice]);
    }

    public function new(Request $request) {
        switch ($request->input('action')) {
            case 'new':
                $invoice = new Invoice();
                $invoice->id = $request->invoice_id;
                $invoice->client_id = $request->client_id;
                $invoice->save();

                $client = Client::findOrFail($request->client_id);
                $client->invoice_count++;
                $client->save();

                foreach ($request->devices as $name) {
                    $device = new Device();
                    $device->name = $name;
                    $device->invoice_id = $invoice->id;
                    $device->save();

                    if (!empty($request[$device->name . '_services'])) {
                        foreach ($request[$device->name . '_services'] as $service_id) {
                            $device_service = new DeviceService();
                            $device_service->device_id = $device->id;
                            $device_service->service_id = $service_id;
                            $device_service->save();
                        }
                    }
                }

                session()->forget('invoice');
                return redirect('/clients');
            case 'new_device':
                $validatedData = $request->validate([
                    'name' => 'required'
                ], [
                    'name.required' => 'Nav norādīts ierīces Vārds.'
                ]);
                
                $invoice = session('invoice');
                $device = new Device();
                $device->id = empty(Device::latest()->first()->id) ? 1 : Device::latest()->first()->id + 1;
                $device->invoice_id = $invoice->id;
                $device->name = $request->name;
                $device->services_aviable = Service::all();
                $invoice->devices[] = $device;
                session()->flash('invoice', $invoice);

                return view('Invoices.invoice_new', ['invoice' => $invoice]);
            case 'back':
                session()->forget('invoice');
                return redirect('/clients');
        }
    }

    public function view($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice = $this->setupInvoice($invoice);

        $this->setupPDF($invoice);

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
                $invoice = $this->setupInvoice($invoice);
            }

            return view('Clients.client_invoices', ['invoices' => $invoices]);
        }

        $invoice = $invoices->first();
        $invoice = $this->setupInvoice($invoice);

        $this->setupPDF($invoice);

        $invoice->pdf = base64_encode(Fpdf::Output('S'));

        return view('Clients.client_invoice_view', ['invoice' => $invoice]);
    }

    public function delete($invoice_id) {
        $devices = Device::where('invoice_id', '=', $invoice_id)->get();
        foreach ($devices as $device) {
            $device_services = DeviceService::where('device_id', '=', $device->id)->get();
            foreach ($device_services as $device_service) {
                $device_service->delete();
            }
            $device->delete();
        }

        $invoice = Invoice::findOrFail($invoice_id);
        $client = Client::findOrFail($invoice->client_id);
        $client->invoice_count = $client->invoice_count == 0 ? 0 : $client->invoice_count--;
        $client->save();
        $invoice->delete();

        return back();
    }

    private function setupInvoice($invoice) {
        $invoice->invoice_number = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $client = Client::findOrFail($invoice->client_id);
        $invoice->first_name = $client->first_name;
        $invoice->last_name = $client->last_name;
        $invoice->phone_number = $client->phone_number;
        $invoice->devices = Device::where('invoice_id', '=', $invoice->id)->get();
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
        if ($invoice->devices != null) {
            Fpdf::SetXY(10, 80);
            Fpdf::Cell(30, 25,  'Ierices: ');
            foreach($invoice->devices as $device) {
                Fpdf::SetY(Fpdf::GetY() + 6);
                Fpdf::Cell(30, 25, $device->name);
            }
        }
    }
}
