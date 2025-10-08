<!DOCTYPE html>
<html lang="en">

<head>
    @include('client.component.head')
</head>

<body>
    @include('component.loadingSpinner')
    @include('client.component.header')
    @yield('content')
    @include('client.component.footer')
    @include('client.component.script')
    {{-- @include('client.component.popup') --}}
</body>

</html>