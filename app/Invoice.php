<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Invoice extends Model {
    use Sortable;

    protected $fillable = ['client_id'];

    public function createAnInvoice($request) {
        if (!isset($request->client_id)) {
            $client = new Client($request->all());
            $client->save();
            $this->client_id = $client->id;
        } else {
            $this->client_id = $request->client_id;
        }

        $this->save();

        $device = new Device($request->all());
        $device->invoice_id = $this->id;
        $device->save();

        if (!empty($request->services)) {
            foreach ($request->services as $service_id) {
                $device_service = new DeviceService();
                $device_service->device_id = $device->id;
                $device_service->service_id = $service_id;
                $device_service->save();
            }
        }

        $has_description = count(array_filter($request->new_service_description)) != 0;
        $has_price = count(array_filter($request->new_service_price)) != 0;

        if ($has_description && $has_price) {
            for ($i = 0; $i < count($request->new_service_category_id); $i++) {
                if ($request->new_service_description[$i] != null && $request->new_service_price[$i] != null) {
                    $service = new Service();
                    $service->service_category_id = $request->new_service_category_id[$i];
                    $service->description = $request->new_service_description[$i];
                    $service->price = $request->new_service_price[$i];
                    $service->save();

                    $device_service = new DeviceService();
                    $device_service->device_id = $device->id;
                    $device_service->service_id = $service->id;
                    $device_service->save();
                }
            }
        }

        $has_name = count(array_filter($request->new_component_name)) != 0;
        $has_price = count(array_filter($request->new_component_price)) != 0;

        if ($has_name && $has_price) {
            $new_component = array_combine($request->new_component_name, $request->new_component_price);
            foreach ($new_component as $name => $price) {
                if ($price != null && $name != null) {
                    $component = new Component();
                    $component->device_id = $device->id;
                    $component->name = $name;
                    $component->price = $price;
                    $component->save();
                }
            }
        }

        return $this;
    }

    public function setupInvoice() {
        $this->invoice_number = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        if (!empty($this->client_id)) {
            $this->client = Client::findOrFail($this->client_id);
        }
        $this->device_types = DeviceType::all();
        $this->service_categories = ServiceCategory::all();
        $this->services = Service::all();
        $this->devices = Device::where('invoice_id', '=', $this->id)->get();
        $this->total_sum = 0;

        $types = DeviceType::all();

        if (!empty($this->devices)) {
            foreach ($this->devices as $device) {
                foreach ($types as $type) {
                    if ($type->id == $device->device_type_id) {
                        $device->type_name = $type->name;
                    }
                }

                $service_ids = DeviceService::where('device_id', '=', $device->id)->get('service_id');
                if (!empty($service_ids)) {
                    $device->services = Service::find($service_ids);
                    $device->service_categories = ServiceCategory::all();

                    foreach ($device->services as $service) {
                        foreach ($device->service_categories as $category) {
                            if ($category->id == $service->service_category_id) {
                                $service->service_category_name = $category->name;
                            }
                        }
                    }
                    $this->total_sum += array_sum(array_column($device->services->toArray(), 'price'));
                }
            }
        }

        $this->total_sum = number_format($this->total_sum, 2, '.', '');

        return null;
    }
}
