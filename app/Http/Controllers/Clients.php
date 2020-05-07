<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\Http\Requests\ClientRequest;
use App\Invoice;

class Clients extends Controller {

    public function index() {
        $clients = Client::sortable()->paginate(15);
        
        foreach ($clients as $client) {
            $invoices = Invoice::where('client_id', '=', $client->id)->get();
            if (!empty($invoices)) {
                $client->invoice_count = $invoices->count();
            }
        }

        return view('Clients.clients', ['clients' => $clients]);
    }

    public function new(ClientRequest $request) {
        $client = new Client($request->all());
        $client->save();
        return back();
    }

    public function edit(Client $client) {
        return view('Clients.client_edit', ['client' => $client]);
    }

    public function update(ClientRequest $request, Client $client) {
        switch ($request->input('action')) {
            case 'update':
                $client->update($request->all());
                return redirect('/clients/edit/' . $client->id);
            case 'back':
                return redirect('/clients');
        }
    }

    public function delete($client_id) {
        $invoices = Invoice::where('client_id', '=', $client_id)->get();
        foreach ($invoices as $invoice) {
            $devices = Device::where('invoice_id', '=', $invoice->id)->get();
            foreach ($devices as $device) {
                $device_services = DeviceService::where('device_id', '=', $device->id)->get();
                foreach ($device_services as $device_service) {
                    $device_service->delete();
                }
                $device->delete();
            }
            $invoice->delete();
        }

        $client = Client::findOrFail($client_id);
        $client->delete();
        return back();
    }
}
