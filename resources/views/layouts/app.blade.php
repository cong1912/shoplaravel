<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('styles/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
  <!-- Styles -->
</head>
<body data-spy="scroll" data-target="#navbar" data-offset="110">
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
  your browser</a> to improve your experience.</p>
<![endif]-->

@include("partials.menu-mobile", ["array" => $categories])

<div class="page mm-slideout">
  @include("partials.header", ["array" => $categories])


  <main class="width-block pb">
    @yield('content')
  </main>

  @include("partials.footer")
</div>


<script src="{{ asset('scripts/vendor.js') }}"></script>
<script src="{{ asset('scripts/main.js') }}"></script>
@yield('script-header')
@yield('script-cart')
@yield('script-filter')
@yield('script-sort')
@yield('script-pagination')
@yield('script')
</body>
</html>
