<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @yield("title")
  </title>

  <link rel="stylesheet" href="{{mix("css/app.css")}}">
  <script src="{{mix('js/app.js')}}"></script>


</head>
<body>
<div id="app">

  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="custom-header">
          <h2>@yield("b-title")</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        @yield("content")
      </div>
    </div>
  </div>
</div>

</body>

</html>
