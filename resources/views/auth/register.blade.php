@extends('layouts._theme')

@section('title', 'registro de usuarios')


@section('content')

<form action="{{url('register')}}" method="post">
    <input type="text" name="name" placeholder="nome de usuario" value="{{old('name')}}">
    <input type="email" name="email" placeholder="email" value="{{old('email')}}">
    <input type="password" name="password" placeholder="senha">
    <input type="password" name="password_confirmation" placeholder="confima sua senha">
    <button type="submit">registrar</button>
</form>

@endsection