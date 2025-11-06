<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Se l'admin NON è loggato
        if (!session('admin_logged_in')) {

            // 🔹 Risposta JSON per chiamate AJAX o Dropzone
            if (
                $request->expectsJson()
                || $request->ajax()
                || $request->is('admin/cars/upload')
                || $request->is('admin/cars/upload/*')
            ) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // 🔹 Altrimenti redirect classico (browser)
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
