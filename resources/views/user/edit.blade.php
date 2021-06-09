@extends("layouts/default")
@section("title", "Update")
@section("b-title", "Update")
@section("content")
  <div class="row">
    <div class="col-12 mb-1">
      <div class="d-flex justify-content-end">
        <a href="{{url("/")}}" class="btn btn-success">Back</a>

      </div>
    </div>
    @if($msg = session("message"))
      <div class="col-12 my-1">
        <div class="alert alert-success">{{$msg}}</div>
      </div>
    @endif
    <div class="col-12">
      <form action="{{route("user.update")}}" method="POST">
        <div class="form-group row">
          <label for="name" class="col-md-2 col-12">Name*</label>
          <div class="col-md col-12">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                   value="{{old('name') ?? Auth::user()['name'] }}"

            />
            <small class="d-block text-muted text-right">Min:2</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-md-2 col-12">Email*</label>
          <div class="col-md col-12">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                   value="{{old('email') ?? Auth::user()['email'] }}"
                   required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-md-2 col-12">Password </label>
          <div class="col-md col-12">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="8"
            />
            <small class="d-block text-muted text-right">Optional / Min:8</small>

          </div>
        </div>
        <div class="form-group row">
          <div class="offset-md-10 col-md offset-6 col text-right">
            <button class="btn btn-primary " type="submit"><span class="show-on-hover">Register&nbsp;</span><i class="fa fa-paper-plane-o" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
    @if($errors->any())
      <div class="col-12">
        @foreach($errors->all() as $err)
          <div class="alert alert-danger">{{$err}}</div>
        @endforeach
      </div>

    @endif
  </div>
@endsection
