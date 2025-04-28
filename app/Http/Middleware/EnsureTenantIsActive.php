<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a tenant is initialized
        if (tenant()) {
            // Check if tenant has status field and if status is 0
            if (tenant('status') == 0) {
                abort(403, 'Your account has been deactivated.');
            }
        }

        return $next($request);
    }
}
