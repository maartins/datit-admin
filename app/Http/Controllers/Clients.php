<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Clients extends Controller
{
    public function index() {
        $clients = Client::sortable()->paginate(15);
        return view('Clients.clients', ['clients' => $clients]);
    }

    public function new(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'numeric'
        ], [
            'first_name.required' => 'Nav norādīts Vārds.',
            'last_name.required' => 'Nav norādīts Uzvārds.',
            'phone_number.required' => 'Nav norādīts Telefona nummurs',
            'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.'
        ]);

        $client = new Client();
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone_number = $request->phone_number;
        $client->save();

        return back();
    }

    public function edit($client_id) {
        $client = Client::findOrFail($client_id);
        return view('Clients.client_edit', ['client' => $client]);
    }

    public function update(Request $request, $client_id) {
        switch ($request->input('action')) {
            case 'update':
                $client = Client::findOrFail($client_id);

                $validatedData = $request->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone_number' => 'required|numeric'
                ], [
                    'first_name.required' => 'Nav norādīts Vārds.',
                    'last_name.required' => 'Nav norādīts Uzvārds.',
                    'phone_number.required' => 'Nav norādīts Telefona nummurs',
                    'phone_number.numeric' => 'Telefona nummurs ir ievadīts kļūdaini.'
                ]);

                $client->first_name = $request->first_name;
                $client->last_name = $request->last_name;
                $client->phone_number = $request->phone_number;
                $client->save();
                
                return redirect('/clients/edit/' . $client->id);
    
            case 'back':
                return redirect('/clients');
        }
    }

    public function delete($client_id) {
        $client = Client::findOrFail($client_id);
        $client->delete();
        return back();
    }
}
