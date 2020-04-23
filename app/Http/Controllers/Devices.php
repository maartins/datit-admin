<?php

namespace App\Http\Controllers;

use App\Client;
use App\Device;
use App\DeviceService;
use App\Invoice;
use App\InvoiceClientDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Devices extends Controller
{
    public function index() {
        $devices = Device::sortable()->paginate(15);
        return view('Devices.devices', ['devices' => $devices]);
    }

    public function edit($device_id) {
        $device = Device::findOrFail($device_id);
        return view('Devices.device_edit', ['device' => $device]);
    }

    public function update(Request $request, $device_id) {
        switch ($request->input('action')) {
            case 'update':
                $device = Device::findOrFail($device_id);
                
                $validatedData = $request->validate([
                    'name' => 'required'
                ], [
                    'name.required' => 'Nav norādīts ierīces Vārds.'
                ]);

                $device->name = $request->name;
                $device->save();

                return redirect('/devices/edit/' . $device->id);
    
            case 'back':
                return redirect('/devices');
        }
    }

    public function delete($device_id) {
        $device_services = DeviceService::where('device_id', '=', $device_id)->get();
        foreach ($device_services as $device_service) {
            $device_service->delete();
        }

        $device = Device::findOrFail($device_id);
        $device->delete();
        return back();
    }
}
