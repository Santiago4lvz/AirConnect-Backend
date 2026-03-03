<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
       
        if (!$request->secure() && App::environment('production')) {
            $httpsUrl = secure_url($request->getRequestUri());
            
           
            if (App::environment(['local', 'staging'])) {
                \Log::channel('security')->info('HTTPS Redirect', [
                    'from' => $request->fullUrl(),
                    'to' => $httpsUrl,
                    'ip' => $request->ip()
                ]);
            }
            
            return redirect()->to($httpsUrl, 301, [], true);
        }

        
        $response = $next($request);
        
       
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        return $response;
    }
}