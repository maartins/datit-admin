<?php

use App\DeviceType;
use Illuminate\Database\Seeder;

class DeviceTypeTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $device_type = new DeviceType();
        $device_type->name = 'Portatīvais';
        $device_type->save();

        $device_type = new DeviceType();
        $device_type->name = 'Stacionārais';
        $device_type->save();

        $device_type = new DeviceType();
        $device_type->name = 'LCD monitors';
        $device_type->save();

        $device_type = new DeviceType();
        $device_type->name = 'Vadības modulis';
        $device_type->save();

        $device_type = new DeviceType();
        $device_type->name = 'Cits';
        $device_type->save();
    }
}
