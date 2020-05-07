<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Invoice extends Model {
    use Sortable;

    protected $fillable = ['client_id'];

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
