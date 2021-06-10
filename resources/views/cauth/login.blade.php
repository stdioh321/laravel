@extends("layouts/default")
@section("title", "Login")
@section("b-title", "Login")
@section("content")
  <div class="row">

    <div class="col-12 mb-1">
      <div class="d-flex justify-content-end">
        <a href="{{route("user.create")}}" class="btn btn-info">Register</a>
      </div>
    </div>
    <div class="col-12">
      <form id="fLogin" action="{{route("auth.login")}}" method="POST">
        @csrf
        <div class="form-group row">
          <label for="email" class="col-md-2 col-12">Email</label>
          <div class="col-md col-12">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                   value="{{old('email') ?? 'test@myemail.com'}}"/>

          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-md-2 col-12">Password</label>
          <div class="col-md col-12 d-flex align-items-center">
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required value="12345678"/>
              <div class="input-group-append">
                <span class="input-group-text"><i class="pointer fa fa-eye" aria-hidden="true"
                                                  id="show-pass"

                  ></i></span>
              </div>

            </div>


          </div>
        </div>
        <div class="form-group row">
          <div class="offset-md-10 col-md offset-6 col">
            <button class="btn btn-success btn-block" type="submit">Login</button>
          </div>
        </div>
      </form>

    </div>

    @if (isset($users) && $users->isNotEmpty())
      <div class="col-12">

        <table class="table table-sm table-sm-responsive table-striped ">
          <thead class="">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
          </thead>
          <tbody>

          @foreach($users as $k => $user)
            {{--            <tr class="{{$k%2==0?'table-warning':''}}">--}}
            <tr>
              <td>{{$user["id"]}}</td>
              <td>{{$user["name"]}}</td>
              <td>{{$user["email"]}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>

      </div>
    @else
      <div class="col-12">
        <div class="alert alert-danger">No Users</div>
      </div>
    @endif
    @if($errors->any())
      <div class="col-12">
        @foreach($errors->all() as $err)
          <div class="alert alert-danger mb-1">{{$err}}</div>
        @endforeach
      </div>

    @endif

  </div>
  <script>
    const urlRedirect = "<?=urldecode( $_GET["url"] ?? "");?>";
    if (urlRedirect) {
      var inputUrl = document.createElement("input");
      inputUrl.hidden = true;
      inputUrl.type = "text";
      inputUrl.value = urlRedirect;
      inputUrl.name = "url";
      var fLogin = document.querySelector("#fLogin");
      if (fLogin) {
        fLogin.appendChild(inputUrl);
      }
    }

    var pass = document.querySelector('#password');
    var showPass = document.querySelector('#show-pass');
    if (showPass && pass)
      showPass.addEventListener("click", function () {
        $("#password")

          .animate({top: "+=2"}, {duration: 50}).animate({top: "-=4"}, {duration: 100}).animate({top: "+=2"}, {duration: 50});
        if (pass.getAttribute('type') == 'password') {

          showPass.classList.remove("fa-eye");
          showPass.classList.add("fa-eye-slash");

          pass.setAttribute('type', 'text');
        } else {

          showPass.classList.add("fa-eye");
          showPass.classList.remove("fa-eye-slash");
          pass.setAttribute('type', 'password');
        }

      });
  </script>
@endsection
