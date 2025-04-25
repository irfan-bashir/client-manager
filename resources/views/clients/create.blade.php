@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Client</h2>
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            @include('clients.form')
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
{{--    <div>--}}
{{--        <label>Subdomain</label>--}}
{{--        <input type="text" name="subdomain" value="{{ old('subdomain', $client->subdomain ?? '') }}" required />--}}
{{--        <small>This will be used as client subdomain (e.g., client1.yourdomain.test)</small>--}}
{{--    </div>--}}
@endsection
