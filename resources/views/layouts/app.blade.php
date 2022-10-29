<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{--Title and Meta--}}
        @meta

        <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        {{--Common App Styles--}}
        {{ Html::style(mix('assets/app/css/app.css')) }}

        {{--Styles--}}
        @yield('styles')

        {{--Head--}}
        @yield('head')

    </head>
    <body class="@yield('body_class')">

        {{--Page--}}
        @yield('page')

        {{--Common Scripts--}}
        {{ Html::script(mix('assets/app/js/app.js')) }}

        {{--Laravel Js Variables--}}
        @tojs

        {{--Scripts--}}
        @yield('scripts')
    </body>
</html>
