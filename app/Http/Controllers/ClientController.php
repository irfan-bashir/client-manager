<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ExportsCsv;

class ClientController extends Controller
{
    use ExportsCsv;
    public function index(Request $request)
    {
        $query = Client::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('poc_name', 'like', "%{$search}%")
                    ->orWhere('company_type', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clients = $query->paginate(10)->withQueryString();

        return view('clients.index', compact('clients'));

//        $clients = Client::latest()->paginate(10);
//        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create_full');

//        $html = view('clients.partials.form')->with(['client' => null])->render();
//        return response($html);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email|max:255',
            'location_url' => 'nullable|url|max:500',
            'poc_name' => 'required|string|max:255',
        ]);
        $client= Client::create($request->except('_token'));

        return redirect()
            ->route('clients.edit', ['client' => $client->id, '#registrations'])
            ->with('success', 'Client created successfully. Now you can add registrations.');
    }

    public function show(Client $client)
    {
        $registrations = $client->registrations()->latest()->paginate(10);
        $tasks = $client->tasks()->latest()->paginate(10);

//        return view('clients.show', compact('client', 'registrations', 'tasks'));
        $html = view('clients.partials.show')->with(compact('client'))->render();
        return response($html);
    }

    public function edit(Client $client)
    {
        $client->load(['registrations', 'tasks']);
        return view('clients.edit_full', compact('client'));
//        $html = view('clients.partials.form')->with(compact('client'))->render();
//        return response($html);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email,'.$client->id.'|max:255',
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
        return $pdf->download('Client_Report_'.$client->name);
    }

    public function export()
    {
        $clients = Client::all();
        $data = $clients->map(function ($client) {
            return [
                $client->name,
                $client->email,
                $client->phone,
                $client->company_type,
                $client->poc_name,
                $client->city,
                $client->address,
                $client->location_url,
                $client->created_at->toDateString(),
            ];
        });

        $headers = ['Name', 'Email', 'Phone', 'Company_Type', 'POC Name', 'City', 'Address', 'Location URL', 'Created At'];

        return $this->exportToCsv('clients.csv', $data, $headers);
    }
}
