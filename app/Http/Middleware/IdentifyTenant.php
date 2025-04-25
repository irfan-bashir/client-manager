<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class IdentifyTenant
{
    public function handle($request, Closure $next)
    {
        $clientSubdomain = $request->route('client');

        // Lookup client in database
        $client = \App\Models\Client::where('subdomain', $clientSubdomain)->first();

        if (! $client) {
            abort(404, 'Client not found.');
        }

        // Store client for later use (you can use service container or Auth guard too)
        App::instance('currentClient', $client);

        return $next($request);
    }
}
