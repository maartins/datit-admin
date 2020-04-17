<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Clients extends Controller
{
    public function index() {
        $clients = Client::sortable()->paginate(2);
        return view('clients', ['clients' => $clients]);
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

        return redirect('/clients');
    }

    public function edit($id) {
        $client = Client::findOrFail($id);
        return view('client_edit', ['client' => $client]);
    }

    public function update(Request $request, $id) {
        $client = Client::findOrFail($id);

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
    }

    public function delete($id) {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect('/clients');
    }
}
