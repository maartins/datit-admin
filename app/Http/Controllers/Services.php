<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\ServiceCategory;

class Services extends Controller {
    public function index() {
        $services = Service::sortable()->paginate(15);
        return view('Services.services', ['services' => $services, 'categories' => ServiceCategory::all()]);
    }

    public function new(ServiceRequest $request) {
        $service = new Service($request->all());
        $service->save();
        return back();
    }

    public function edit(Service $service) {
        return view('Services.service_edit', ['service' => $service, 'categories' => ServiceCategory::all()]);
    }

    public function update(ServiceRequest $request, Service $service) {
        switch ($request->input('action')) {
            case 'update':
                $service->update($request->all());
                return redirect('/services/edit/' . $service->id);
            case 'back':
                return redirect('/services');
        }
    }

    public function delete(Service $service) {
        $service->delete();
        return back();
    }
}
