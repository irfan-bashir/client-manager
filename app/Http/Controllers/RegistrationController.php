<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Client $client)
    {
        $registrations = $client->registrations()->latest()->get();
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
        return redirect()->route('registrations.index', $client)->with('success', 'Registration added.');
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
        return redirect()->route('registrations.index', $client)->with('success', 'Registration updated.');
    }

    public function destroy(Client $client, Registration $registration)
    {
        $this->authorizeClient($client, $registration);
        $registration->delete();
        return redirect()->route('registrations.index', $client)->with('success', 'Registration deleted.');
    }

    private function authorizeClient(Client $client, Registration $registration)
    {
        abort_if($registration->client_id !== $client->id, 403);
    }

    private function getOrganizations()
    {
        return collect([
            'SECP /CEO',
            'FBR',
            'PTA',
            'PEC',
            'Department of Tourism',
            'IPO',
            'PSEB',
            'Other',
            'KPRA',
            'SRA',
            'PRA',
            'BRA',
        ])->sort()->values();
    }
}
