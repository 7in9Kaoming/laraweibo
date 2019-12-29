@extends('layouts.default')

@section('content')
    @if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')
        </section>
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
    @else
    <div class="jumbotron">
      <h1 class="display-4">Hello, Laravel</h1>
      <p class="lead">一切，从这里开始。</p>
      <hr class="my-4">
      <p class="lead">
        <a class="btn btn-success btn-lg" href="{{ route('signup') }}" role="button">现在注册</a>
      </p>
    </div>
    @endif
@stop
