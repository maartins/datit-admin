<?php

use App\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $client = new Client();
        $client->first_name = 'Ābols';
        $client->last_name = 'Zaļais';
        $client->phone_number = '123456789';
        $client->address = 'Lielā iela 12';
        $client->client_type = 'person';
        $client->company_name = '';
        $client->save();

        $client = new Client();
        $client->first_name = 'Normunds';
        $client->last_name = 'Kautkāds';
        $client->phone_number = '4444444';
        $client->address = 'Neatrdes 11';
        $client->client_type = 'company';
        $client->company_name = 'SIA LoGo';
        $client->save();
    }
}
