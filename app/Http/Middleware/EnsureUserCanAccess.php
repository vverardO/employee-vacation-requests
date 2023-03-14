<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $route = Str::of(Route::current()->getName())->explode('.')->first();

        $denied = auth()->user()->role->permissions->where('route_title', $route)->isEmpty();

        if ($denied) {
            session()->flash('message', 'Você não tem permissão!');
            session()->flash('type', 'warning');

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
