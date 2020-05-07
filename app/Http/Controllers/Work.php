<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use PDF;

class Work extends Controller {
    public function index() {
        $invoice = new Invoice();
        $invoice->setupInvoice();
        return view('work', ['invoice' => $invoice]);
    }

    public function new(InvoiceRequest $request) {
        switch ($request->input('action')) {
            case 'new':
                $client = new Client($request->all());
                $client->save();

                $invoice = new Invoice($request->all());
                $invoice->client_id = $client->id;
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

                return redirect('/work');
            case 'new-and-print':
                $client = new Client($request->all());
                $client->save();

                $invoice = new Invoice($request->all());
                $invoice->client_id = $client->id;
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

                $invoice->setupInvoice();
                $invoice->pdf = base64_encode(PDF::loadView('PDFS.main', compact('invoice'))->output());

                return view('Invoices.invoice_view', ['invoice' => $invoice]);
            default:
                return redirect('/work');
        }
    }
}
