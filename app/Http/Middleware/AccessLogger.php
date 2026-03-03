<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AccessLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Registrar acceso
        Log::channel('access')->info('Access Log', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
            'user_id' => auth()->id() ?? 'guest',
            'timestamp' => now()->toISOString(),
        ]);

        return $response;
    }
}