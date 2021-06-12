<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
  <title>
    Error
  </title>

  <link rel="stylesheet" href="{{mix("css/app.css")}}">
  <script src="{{mix('js/app.js')}}"></script>

  <style>
    #content {
      display: flex;
      justify-content: center;
      align-content: center;
      align-items: center;
      flex-wrap: wrap;
      height: 100vh;
    }

    #content > * {
      flex: 1 100%;
      text-align: center;
    }
    #content > .exception {
      font-size: 3em;
      color: darkred;
    }
    #content > .message {
      font-size: 1.2em;
      color: darkred;
    }
  </style>
</head>
<body>
<div id="app">
  <div class="container">
    <div class="row">
      <div class="col-12" id="content">
        <div class="exception">
          @yield("code", "500") | @yield("exMessage", "Server Error")
        </div>
        <div class="message">
          @yield("message")
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>
