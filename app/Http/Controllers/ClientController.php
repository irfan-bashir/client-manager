<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $html = view('clients.partials.form')->with(['client' => null])->render();
        return response($html);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email|max:255',
            'location_url' => 'nullable|url|max:500',
            'poc_name' => 'required|string|max:255',
        ]);
        Client::create($request->except('_token'));

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $html = view('clients.partials.show')->with(compact('client'))->render();
        return response($html);
    }

    public function edit(Client $client)
    {
        $html = view('clients.partials.form')->with(compact('client'))->render();
        return response($html);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email|max:255',
            'location_url' => 'nullable|url|max:500',
            'poc_name' => 'required|string|max:255',
        ]);

        $client->update($request->except('_token'));
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    public function generatePDF(Client $client)
    {
        $pdf = Pdf::loadView('clients.pdf', compact('client'));
        return $pdf->download($client->name . '_details.pdf');
    }
}
