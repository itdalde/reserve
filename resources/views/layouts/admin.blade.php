<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.includes.head')

</head>
<body class="bg-light">


<div id="overlay"></div>
<div id='loader' class="a" style="--n: 5;margin-top: 50vh;
    text-align: center;">
    <div class="dot" style="--i: 0"></div>
    <div class="dot" style="--i: 1"></div>
    <div class="dot" style="--i: 2"></div>
    <div class="dot" style="--i: 3"></div>
    <div class="dot" style="--i: 4"></div>
</div>
<div id="db-wrapper">
@include('layouts.includes.sidebar')

<!-- Page content -->
    <div id="page-content">
    @include('layouts.includes.header')
    <!-- Container fluid -->
        <div class="bg-light pt-14 pb-21"></div>
        <div class="container-fluid mt-n22 px-6">
            @yield('content')
        </div>
    </div>
</div>
@include('layouts.includes.footer_scripts')

@include('layouts.includes.modal')
@yield('content_javascript')
</body>
</html>
