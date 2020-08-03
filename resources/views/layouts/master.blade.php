<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

    {{-- Header --}}
    @include('includes.header')

    {{-- Content --}}
    @yield('content')
    
    <!-- jquery js -->
    <script src="{{ asset('js/jquery.js') }}"></script> 

    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- fontawesome js -->
    <!-- <script src="../js/all.min.js"></script> -->

    <!-- <script src="js/jquery-3.3.1.slim.min.js"></script> -->
    <!-- <script src="js/popper.min.js"></script> -->

    @yield('jQuery')

</body>
</html>