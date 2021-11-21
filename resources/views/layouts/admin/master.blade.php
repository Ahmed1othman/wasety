<!DOCTYPE html>
<html dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}"  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="this my acount to my son" />
        <meta name="keywords" content="coins,wasity" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('title')</title>
        @include('layouts.admin.header')
    </head>
    <body id="app-container" class="menu-default show-spinner">
        @include('layouts.admin.navbar')
        @include('layouts.admin.sidebar')
        <main>
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
        @include('layouts.admin.footer')
        @include('layouts.admin.footer-script')
    </body>
</html>
