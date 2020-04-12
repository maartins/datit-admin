<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class Services extends Controller
{
    public function index() {
        $services = Service::all();
        return view('services', ['services' => $services]);
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

        return redirect('/services');
    }

    public function edit($id) {
        $service = Service::findOrFail($id);
        return view('service_edit', ['service' => $service]);
    }

    public function update(Request $request, $id) {
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
        
        return view('service_edit', ['service' => $service]);
    }

    public function delete($id) {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect('/services');
    }
}
