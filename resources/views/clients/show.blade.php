@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Client Details</h2>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Name:</strong> {{ $client->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $client->email }}</li>
            <li class="list-group-item"><strong>Phone:</strong> {{ $client->phone }}</li>
            <li class="list-group-item"><strong>POC Name:</strong> {{ $client->poc_name ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Company Type:</strong> {{ $client->company_type }}</li>
            <li class="list-group-item"><strong>Address:</strong> {{ $client->address }}</li>
            <li class="list-group-item"><strong>City:</strong> {{ $client->city }}</li>

            <!-- If you have additional fields in your database, add them here -->
            @if($client->registration_number)
                <li class="list-group-item"><strong>Registration Number:</strong> {{ $client->registration_number }}</li>
            @endif

            @if($client->ntn_number)
                <li class="list-group-item"><strong>NTN Number:</strong> {{ $client->ntn_number }}</li>
            @endif

            @if($client->strn_number)
                <li class="list-group-item"><strong>STRN Number:</strong> {{ $client->strn_number }}</li>
            @endif

            <!-- Add any other fields you have in your form -->
        </ul>

        <a href="{{ route('clients.index') }}" class="btn btn-primary mt-3">Back to Clients</a>
    </div>
@endsection
