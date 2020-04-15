<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Devices extends Controller
{
    public function index() {
        $devices = Device::sortable()->paginate(2);
        return view('devices', ['devices' => $devices]);
    }

    public function new(Request $request, $client_id) {
        $validatedData = $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nav norādīts Vārds.'
        ]);

        $device = new Device();
        $device->name = $request->name;
        $device->client_id = $client_id;
        $device->save();

        return redirect('/invoices/add/' . $client_id);
    }

    public function edit($device_id) {
        $device = Device::findOrFail($device_id);
        return view('device_edit', ['device' => $device]);
    }

    public function update(Request $request, $device_id) {
        $validatedData = $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nav norādīts Vārds.'
        ]);

        $device = Device::findOrFail($device_id);
        $device->name = $request->name;
        $device->save();
        
        return view('device_edit', ['device' => $device]);
    }

    public function delete($device_id) {
        $device = Device::findOrFail($device_id);
        $device->delete();
        return redirect('/devices');
    }
}
