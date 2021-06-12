<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
//      \Illuminate\Auth\AuthenticationException::class,
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register()
  {
    $this->reportable(function (Throwable $e) {
      //

    });

    $this->renderable(function (ServerException $e, $request) {
      error_log($e->getMessage());
      return response()->view("errors.500", ["message" => $e->getMessage(), "code" => $e->getCode(), "exMessage" => $e->getExMessage()]);
      //      return response()->json(["error" => "Tudo Errado"]);
    });
    $this->renderable(function (Forbidden $e, $request) {
      error_log($e->getMessage());
      return response($e->getMessage(), Response::HTTP_FORBIDDEN);
    });

    $this->renderable(function (\Error $e, $request) {
      error_log("=============================");
      error_log(get_class($e));
      error_log($e->getMessage());
      error_log($e->getCode());
      error_log("=============================");
//      return response()->view("errors.500", ["message" => $e->getMessage()]);
      //      return response()->json(["error" => "Tudo Errado"]);
    });
  }



//  public function unauthenticated(Request $request, AuthenticationException $exc): \Symfony\Component\HttpFoundation\Response
//  {
//    error_log("==============================================================");
//    error_log("unauthenticated");
//    error_log("==============================================================");
//    return parent::unauthenticated($request, $exc);
//
//
//  }
}
