@extends("errors/default")
@section("code", $code ?? "500")
@section("exMessage", $exMessage ?? "Server Error")
@section("message", $message ?? "")
