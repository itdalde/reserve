<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.includes.head')

</head>
<body class="bg-light">
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

@yield('content_javascript')
@include('layouts.includes.modal')
</body>
</html>
