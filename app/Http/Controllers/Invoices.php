<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use PDF;

class Invoices extends Controller {

    public function index() {
        $invoices = Invoice::sortable()->paginate(15);
        
        foreach ($invoices as $invoice) {
            $invoice->setupInvoice();
        }

        return view('Invoices.invoices', ['invoices' => $invoices]);
    }

    public function add($client_id) {
        $invoice = new Invoice();
        $invoice->client_id = $client_id;
        $invoice->setupInvoice();
        return view('Invoices.invoice_new', ['invoice' => $invoice]);
    }

    public function new(InvoiceRequest $request) {
        switch ($request->input('action')) {
            case 'new':
                $invoice = new Invoice($request->all());
                $invoice->save();

                $device = new Device($request->all());
                $device->invoice_id = $invoice->id;
                $device->save();

                if (!empty($request->services)) {
                    foreach ($request->services as $service_id) {
                        $device_service = new DeviceService();
                        $device_service->device_id = $device->id;
                        $device_service->service_id = $service_id;
                        $device_service->save();
                    }
                }
                return redirect('/clients');
            case 'back':
                return redirect('/clients');
        }
    }

    public function view($invoice_id) {
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice->setupInvoice();
        $invoice->pdf = base64_encode(PDF::loadView('PDFS.main', compact('invoice'))->output());
        return view('Invoices.invoice_view', ['invoice' => $invoice]);
    }

    public function viewClient($client_id) {
        $invoices = Invoice::sortable()->where('client_id', '=', $client_id)->paginate(15);

        foreach ($invoices as $invoice) {
            $invoice->setupInvoice();
        }

        return view('Clients.client_invoices', ['invoices' => $invoices]);
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

        if (Invoice::where('client_id', '=', $client->id)->get()->count() == 0) {
            return redirect('/clients');
        }
        return back();
    }
}
