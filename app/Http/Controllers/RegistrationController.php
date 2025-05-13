<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ExportsCsv;

class RegistrationController extends Controller
{
    use ExportsCsv;
    public function index(Client $client)
    {
        $registrations = $client->registrations()->latest()->paginate(10);
        return view('registrations.index', compact('client', 'registrations'));
    }

    public function create(Client $client)
    {
        $organizations = $this->getOrganizations();
        return view('registrations.create', compact('client', 'organizations'));
    }

    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'organization_name' => 'required',
            'secp_ceo' => 'nullable|string',
            'secp_director' => 'nullable|string',
            'secp_next_of_kin' => 'nullable|string',
            'username' => 'required',
            'password' => 'required',
            'pin' => 'nullable',
        ]);


        $client->registrations()->create($validated);
        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Registration added successfully.')
            ->withFragment('registrations');
//        return redirect()->route('registrations.index', $client)->with('success', 'Registration added.');
    }

    public function edit(Client $client, Registration $registration)
    {
        $this->authorizeClient($client, $registration);
        $organizations = $this->getOrganizations();
        return view('registrations.edit', compact('client', 'registration', 'organizations'));
    }

    public function update(Request $request, Client $client, Registration $registration)
    {
        $this->authorizeClient($client, $registration);
        $validated = $request->validate([
            'organization_name' => 'required',
            'secp_ceo' => 'nullable|string',
            'secp_director' => 'nullable|string',
            'secp_next_of_kin' => 'nullable|string',
            'username' => 'required',
            'password' => 'required',
            'pin' => 'nullable',
        ]);

        $registration->update($validated);
        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Registration updated successfully.')
            ->withFragment('registrations');
    }

    public function destroy(Client $client, Registration $registration)
    {
        $this->authorizeClient($client, $registration);
        $registration->delete();
        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Registration deleted successfully.')
            ->withFragment('registrations');
//        return redirect()->route('registrations.index', $client)->with('success', 'Registration deleted.');
    }

    public function export()
    {
        $registrations = Registration::all();
        $data = $registrations->map(function ($registration) {
            return [
                $registration->organization_name,
                $registration->username,
                $registration->password,
                $registration->pin,
            ];
        });

        $headers = ['Organization Name', 'User Name', 'Password', 'Pin'];

        return $this->exportToCsv('registrations.csv', $data, $headers);
    }

    private function authorizeClient(Client $client, Registration $registration)
    {
        abort_if($registration->client_id !== $client->id, 403);
    }

    private function getOrganizations()
    {
        return collect([
            'BRA',
            'Department of Tourism',
            'FBR',
            'IPO',
            'KPRA',
            'Other',
            'PEC',
            'PRA',
            'PTA',
            'PSEB',
            'SECP / CEO',
            'SECP / Director',
            'SECP/ Next of Kin',
            'SRA'
        ])->sort()->values();
    }
}
