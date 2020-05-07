<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\ServiceCategory;

class Services extends Controller {
    public function index() {
        $services = Service::sortable()->paginate(15);
        $services->service_categories = ServiceCategory::all();

        foreach ($services as $service) {
            foreach ($services->service_categories as $category) {
                if ($category->id == $service->service_category_id) {
                    $service->service_category_name = $category->name;
                }
            }
        }

        return view('Services.services', ['services' => $services]);
    }

    public function new(ServiceRequest $request) {
        $service = new Service($request->all());
        $service->save();
        return back();
    }

    public function edit(Service $service) {
        $service->service_categories = ServiceCategory::all();
        return view('Services.service_edit', ['service' => $service]);
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
