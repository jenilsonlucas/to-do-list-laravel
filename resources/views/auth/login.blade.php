@extends('layouts._theme')


@section('title', 'login Autenticação')

@section('content')
<form action="{{url('login')}}" method="post">
    @csrf
    <input type="email" name="email" placeholder="email" value="{{old('email')}}"> 
    <input type="password" name="password" placeholder="password">
    <label><input type="checkbox" name="remember">lembre me</label>
    <button type="submit">Entrar</button>
</form>

@endsection