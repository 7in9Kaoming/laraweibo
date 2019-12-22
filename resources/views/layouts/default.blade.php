<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
    <!-- 头部导航栏 -->
    @include('layouts._header')

    <div class="container">
  	  <div class="offset-md-1 col-md-10">
          <!-- 提示信息 -->
  		    @include('shared._message')
          <!-- 网页主体 -->
          @yield('content')
          <!-- 页脚 -->
          @include('layouts._footer')
  	  </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
