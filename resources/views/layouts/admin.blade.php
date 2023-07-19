<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.includes.head')

</head>
<body class="bg-light">


<div id="overlay"></div>
<div id='loader' class="a" style="--n: 5;
    text-align: center;"> <svg width="100%" height="100%">
        <defs>
            <pattern id="polka-dots" x="0" y="0"                    width="100" height="100"
                     patternUnits="userSpaceOnUse">
                <circle fill="#be9ddf" cx="25" cy="25" r="3"></circle>
            </pattern>
            <style>
                @import url("https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i");
            </style>

        </defs>



        <text x="50%" y="60%"  text-anchor="middle"  >
            Reserve
        </text>
    </svg>
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
