<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Throwable;

class CustomAuthenticate extends Middleware
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   * @throws \Illuminate\Auth\AuthenticationException
   */
  public function handle(Request $request, Closure $next, ...$guards)
  {
    if(! \Auth::check())
    throw new AuthenticationException(
      'Unauthenticated.', $guards, $this->redirectTo($request)
    );
    return $next($request);
//    return parent::handle($request, $next, $guards);
  }

  protected function redirectTo($request)
  {
    if (!$request->expectsJson()) {
      return route('auth.login-form');
    }
  }
}
