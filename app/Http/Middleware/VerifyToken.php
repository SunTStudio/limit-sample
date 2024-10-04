<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // return $next($request);

         $token = $request->session()->get('token');

         if (!$token) {
             return redirect()->route('login')->withErrors([
                 'message' => 'Please log in first.',
             ]);
         }

         $client = new Client();
         $response = $client->get(env('API_BASE_URL') . '/api/user', [
             'headers' => [
                 'Authorization' => "Bearer $token",
             ]
         ]);

         if ($response->getStatusCode() == 200) {
             return $next($request);
         }

         return redirect()->route('login')->withErrors([
             'message' => 'Invalid token.',
         ]);
    }
}
