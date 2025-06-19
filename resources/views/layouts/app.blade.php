<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>H1D023011 | @yield('title')</title>

  @include('layouts.style')

  @livewireStyles

</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
 
    @include('layouts.navbar')

    @include('layouts.sidebar')

    @yield('content')
  
    @include('layouts.footer')


  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>


@include('layouts.script')

@livewireScripts()
</body>
</html>
