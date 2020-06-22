<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\ServiceCategory;
use App\DeviceType;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\Service;
use PDF;

class Work extends Controller {
    public function index() {
        $invoice = new Invoice();
        return view('work', ['invoice' => $invoice, 'categories' => ServiceCategory::all(), 'device_types' => DeviceType::all(), 'services' => Service::all()]);
    }

    public function new(InvoiceRequest $request) {
        switch ($request->input('action')) {
            case 'new':
                $invoice = new Invoice($request->all());
                $invoice->createAnInvoice($request);
                return redirect('/work');
            case 'new-and-print':
                $invoice = new Invoice($request->all());
                $invoice->createAnInvoice($request);
                $invoice->pdf = base64_encode(PDF::loadView('PDFS.main', compact('invoice'))->output());
                return view('Invoices.invoice_view', ['invoice' => $invoice]);
            default:
                return redirect('/work');
        }
    }
}
