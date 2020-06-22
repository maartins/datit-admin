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

    public function getTotalSumAttribute() {
        $total_sum = 0;

        if (!empty($this->devices)) {
            foreach ($this->devices as $device) {
                if (!empty($device->services)) {
                    $total_sum += array_sum(array_column($device->services->toArray(), 'price'));
                }
            }
        }

        $total_sum = number_format($total_sum, 2, '.', '');

        return $total_sum;
    }

    public function getInvoiceNumberAttribute() {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function devices() {
        return $this->hasMany('App\Device');
    }
}
