@extends("layouts/default")
@section("title", "Login")
@section("b-title", "Login")
@section("content")
  <div class="row">
    <div class="col-12 mb-1">
      <div class="d-flex justify-content-end">
        <a href="{{route("auth.register-form")}}" class="btn btn-info">Register</a>
      </div>
    </div>
    <div class="col-12">
      <form action="{{route("auth.login")}}" method="POST">
        @csrf
        <div class="form-group row">
          <label for="email" class="col-md-2 col-12">Email</label>
          <div class="col-md col-12">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                   value="{{old('email') ?? 'becir69483@edmondpt.com'}}"/>

          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-md-2 col-12">Password</label>
          <div class="col-md col-12 d-flex align-items-center">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required value="12345678"/>
            <span class="ml-1 pointer"
                  onclick="javascript:var p =document.querySelector('#password'); p.getAttribute('type')=='password'?p.setAttribute('type','text'):p.setAttribute('type','password')"
            ><i class="fa fa-eye" aria-hidden="true"></i></span>
          </div>
        </div>
        <div class="form-group row">
          <div class="offset-md-10 col-md offset-6 col">
            <button class="btn btn-success btn-block" type="submit">Login</button>
          </div>
        </div>
      </form>

    </div>

    @if($errors->any())
      <div class="col-12">
        @foreach($errors->all() as $err)
          <div class="alert alert-danger mb-1">{{$err}}</div>
        @endforeach
      </div>

    @endif

  </div>
@endsection
