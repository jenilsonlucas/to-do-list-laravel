@extends('layouts._theme')

@section('content')
    <div>
        <h1>Verifique seu e-mail</h1>

        @if (session('message'))
            <p>{{ session('message') }}</p>
        @endif

        <p>Antes de continuar, por favor verifique seu e-mail. Se você não recebeu o e-mail, clique abaixo para reenviar.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Reenviar link de verificação</button>
        </form>
    </div>
@endsection
