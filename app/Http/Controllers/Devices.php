<?php

namespace App\Http\Controllers;

use App\Device;
use App\DeviceService;
use App\DeviceType;
use App\Http\Requests\DeviceRequest;

class Devices extends Controller
{
    public function index() {
        $devices = Device::sortable()->paginate(15);
        $types = DeviceType::all();
        
        foreach ($devices as $device) {
            foreach ($types as $type) {
                if ($type->id == $device->type) {
                    $device->type_name = $type->name;
                }
            }
        }

        return view('Devices.devices', ['devices' => $devices]);
    }

    public function edit(Device $device) {
        $device->types = DeviceType::all();
        
        foreach ($device->types as $type) {
            if ($type->id == $device->type) {
                $device->selected = $device->type;
            }
        }

        return view('Devices.device_edit', ['device' => $device]);
    }

    public function update(DeviceRequest $request, Device $device) {
        switch ($request->input('action')) {
            case 'update':
                $device->type = $request->type;
                $device->name = $request->name;
                $device->additions = $request->additions;
                $device->save();

                return redirect('/devices/edit/' . $device->id);
    
            case 'back':
                return redirect('/devices');
        }
    }

    public function delete(Device $device) {
        $device_services = DeviceService::where('device_id', '=', $device->id)->get();

        foreach ($device_services as $device_service) {
            $device_service->delete();
        }

        $device->delete();
        return back();
    }
}
