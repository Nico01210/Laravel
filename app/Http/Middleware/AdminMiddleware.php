<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
        
        if (!Auth::user()->is_admin) {
            // Si c'est une requête AJAX, retourner une erreur JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès refusé'], 403);
            }
            // Sinon, afficher la page d'erreur 403
            abort(403);
        }

        return $next($request);
    }
}
