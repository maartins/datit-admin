<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\DeviceType;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\Service;
use PDF;

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

    public function new(InvoiceRequest $request) {
        switch ($request->input('action')) {
            case 'new':
                $invoice = new Invoice();
                $invoice->id = $request->invoice_id;
                $invoice->client_id = $request->client_id;
                $invoice->save();

                $client = Client::findOrFail($request->client_id);
                $client->save();

                if (!empty($request->device_types)) {
                    for ($i = 0; $i < count($request->device_types); $i++) { 
                        $device = new Device();
                        $device->type = $request->device_types[$i];
                        $device->name = $request->device_names[$i];
                        $device->additions = $request->device_additions[$i];
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
                }

                session()->forget('invoice');
                return redirect('/clients');
            case 'new_device':
                $invoice = session('invoice');
                $device = new Device();
                $device->id = empty(Device::latest()->first()->id) ? 1 : Device::latest()->first()->id + 1;
                $device->invoice_id = $invoice->id;
                $device->type = $request->device_type;
                $device->name = $request->device_name;
                $device->additions = $request->device_addition;
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
        $invoice->pdf = base64_encode($this->setupPDF($invoice));

        return view('Invoices.invoice_view', ['invoice' => $invoice]);
    }

    public function viewClient($client_id) {
        $invoices = Invoice::sortable()->where('client_id', '=', $client_id)->paginate(15);

        foreach ($invoices as $invoice) {
            $invoice = $this->setupInvoice($invoice);
        }

        return view('Clients.client_invoices', ['invoices' => $invoices]);

        $invoice = $invoices->first();
        $invoice = $this->setupInvoice($invoice);
        $invoice->pdf = base64_encode($this->setupPDF($invoice));

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
        $client->save();
        $invoice->delete();

        if (Invoice::where('client_id', '=', $client->id)->get()->count() > 1) {
            return back();
        }
        return redirect('/clients');
    }

    private function setupInvoice($invoice) {
        $invoice->invoice_number = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $client = Client::findOrFail($invoice->client_id);
        $invoice->client = $client;
        $invoice->device_types = DeviceType::all();
        $invoice->devices = Device::where('invoice_id', '=', $invoice->id)->get();
        $invoice->total_sum = 0;

        $types = DeviceType::all();

        if (!empty($invoice->devices)) {
            foreach ($invoice->devices as $device) {
                foreach ($types as $type) {
                    if ($type->id == $device->type) {
                        $device->type_name = $type->name;
                    }
                }

                $service_ids = DeviceService::where('device_id', '=', $device->id)->get('service_id');
                if (!empty($service_ids)) {
                    $device->services = Service::find($service_ids);
                    $invoice->total_sum += array_sum(array_column($device->services->toArray(), 'price'));
                }
            }
        }

        $invoice->total_sum = number_format($invoice->total_sum, 2);
        
        return $invoice;
    }

    private function setupPDF($invoice) {
        $pdf = PDF::loadView('PDFS.main', compact('invoice'));
        return $pdf->output();
    }
}
