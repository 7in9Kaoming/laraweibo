<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="#">Weibo App</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav"> 
	  <li class="nav-item">
            <a class="nav-link" href="#">帮助</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">登录</a>
          </li>
	</ul>
      </div>
      <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>-->
    </nav>    

   <div class="container">
     @yield('content')
   </div>

    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
