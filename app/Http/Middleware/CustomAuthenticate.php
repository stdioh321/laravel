<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
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

    if (in_array("not", $guards)) {
      if (\Auth::check()) return $this->onAuthFail($request, $guards);
    } else {

      if (!\Auth::check()) return $this->onAuthFail($request, $guards);

    }

    return $next($request);
//    return parent::handle($request, $next, $guards);
  }

  protected function redirectTo($request, string $route = null)
  {


    if (!$request->expectsJson()) {
      $url = $request->fullUrl();
      return route($route ?? 'auth.login-form', ["url" => urlencode($url)]);
    }


  }

  /**
   * @throws AuthenticationException
   */
  public function onAuthFail(Request $request, $guards)
  {

//    throw new AuthenticationException(
//      'Unauthenticated.', $guards, $this->redirectTo($request)
//    );
//    $res = new Response();
//    $res->setStatusCode(Response::HTTP_UNAUTHORIZED);
//    $res->setContent("Hello");
    return redirect(route("auth.login-form", ["url" => $request->fullUrl()]))->withErrors(["errors" => ["message" => "Unauthorized"]]);
  }
}
