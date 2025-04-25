@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Registration</h2>
        <form action="{{ route('registrations.store', $client->id) }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label>Organization Name</label>
                <select name="organization_name" class="form-control" required>
                    <option value="">Select</option>
                    <option>SECP / CEO</option>
                    <option>FBR</option>
                    <option>PTA</option>
                    <option>PEC</option>
                    <option>Department of Tourism</option>
                    <option>IPO</option>
                    <option>PSEB</option>
                    <option>Other</option>
                    <option>KPRA</option>
                    <option>SRA</option>
                    <option>PRA</option>
                    <option>BRA</option>
                    <option>SECP / Director</option>
                    <option>SECP/ Next of Kin</option>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>Password</label>
                <input type="text" name="password" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>PIN</label>
                <input type="text" name="pin" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
