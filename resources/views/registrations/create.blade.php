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
                    <option>BRA</option>
                    <option>Department of Tourism</option>
                    <option>DRAP</option>
                    <option>EPAD</option>
                    <option>FBR</option>
                    <option>ICCI</option>
                    <option>IPO</option>
                    <option>KPRA</option>
                    <option>Other</option>
                    <option>PEC</option>
                    <option>PRA</option>
                    <option>PSW</option>
                    <option>PTA</option>
                    <option>PSEB</option>
                    <option>Punjab (AOP)</option>
                    <option>SECP / CEO</option>
                    <option>SECP / Director</option>
                    <option>SECP/ Next of Kin</option>
                    <option>SRA</option>
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
