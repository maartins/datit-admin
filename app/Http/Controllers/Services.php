<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class Services extends Controller
{
    public function index() {
        $services = Service::sortable()->paginate(15);
        return view('Services.services', ['services' => $services]);
    }

    public function new(Request $request) {
        $validatedData = $request->validate([
            'description' => 'required',
            'price' => 'required|numeric'
        ], [
            'description.required' => 'Nav norādīts Apraksts.',
            'price.required' => 'Nav norādīta Cena.',
            'price.numeric' => 'Cena nav pareizi norādīta.'
        ]);

        $service = new Service();
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        return back();
    }

    public function edit($service_id) {
        $service = Service::findOrFail($service_id);
        return view('Services.service_edit', ['service' => $service]);
    }

    public function update(Request $request, $service_id) {
        switch ($request->input('action')) {
            case 'update':
                $service = Service::findOrFail($service_id);

                $validatedData = $request->validate([
                    'description' => 'required',
                    'price' => 'required|numeric'
                ], [
                    'description.required' => 'Nav norādīts Apraksts.',
                    'price.required' => 'Nav norādīta Cena.',
                    'price.numeric' => 'Cena nav pareizi norādīta.'
                ]);

                $service->description = $request->description;
                $service->price = $request->price;
                $service->save();
                
                return redirect('/services/edit/' . $service->id);
    
            case 'back':
                return redirect('/services');
        }
    }

    public function delete($service_id) {
        $service = Service::findOrFail($service_id);
        $service->delete();
        return back();
    }
}
