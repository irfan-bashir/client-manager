@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Registration - {{ $client->name }}</h2>

        <form method="POST" action="{{ route('registrations.update', [$client->id, $registration->id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Organization Name</label>
                <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $registration->organization_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $registration->username) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" name="password" class="form-control" value="{{ old('password', $registration->password) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">PIN</label>
                <input type="text" name="pin" class="form-control" value="{{ old('pin', $registration->pin) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('registrations.index', $client->id) }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
