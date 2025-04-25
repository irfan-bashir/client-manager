<!DOCTYPE html>
<html>
<head>
    <title>Client Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        .details { margin: 20px 0; }
    </style>
</head>
<body>
<h1>{{ $client->name }} - Details</h1>
<div class="details">
    <p><strong>Company Type:</strong> {{ $client->company_type }}</p>
    <p><strong>POC Name:</strong> {{ $client->poc_name }}</p>
    <p><strong>Contact:</strong> {{ $client->phone }}</p>
    <p><strong>Email:</strong> {{ $client->email }}</p>
    <p><strong>City:</strong> {{ $client->city }}</p>
    <p><strong>Location:</strong> {{ $client->address }}</p>
</div>
</body>
</html>
