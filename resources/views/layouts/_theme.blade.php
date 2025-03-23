<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Name - @yield('title')</title>
</head>

<body>
    <h1>Application To do List</h1>
    <a href="{{route('login')}}">Login</a>
    @if(session('message'))
        <h3>{{session('message')}}</h3>
    @endif

    @yield('content')


</body>

</html>