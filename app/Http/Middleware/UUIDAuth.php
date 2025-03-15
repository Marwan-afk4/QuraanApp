<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UUIDAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $deviceUuid = $request->header('Device-UUID');

        if (!$deviceUuid) {
            return response()->json([
                'message' => 'Device UUID is required',
            ]);
        }
        $user = User::firstOrCreate([
            'uuid' => $deviceUuid
        ]);
        Auth::login($user);
        return $next($request);
    }
}
