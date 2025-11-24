<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffOnly
{
     public function handle(Request $request, Closure $next): Response
     {
          // Jika owner, redirect ke dashboard owner
          if (auth()->check() && auth()->user()->isOwner()) {
               return redirect()->route('owner.dashboard');
          }

          return $next($request);
     }
}
