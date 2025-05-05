<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Subscription;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        // Get latest subscription for tenant
        $subscription = Subscription::latest()->first();

        if (!$subscription || Carbon::parse($subscription->end_date)->isPast()) {
            // Show blocked message or redirect
            return response()->view('app.subscription_expired');
        }

        return $next($request);
    }
}

