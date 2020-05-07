<?php

use App\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $service_category = new ServiceCategory();
        $service_category->name = 'Programmatūra';
        $service_category->save();

        $service_category = new ServiceCategory();
        $service_category->name = 'Dzelži';
        $service_category->save();

        $service_category = new ServiceCategory();
        $service_category->name = 'Cits';
        $service_category->save();
    }
}
