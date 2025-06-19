<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de email</title>
    <link rel="shortcut icon" href="{{asset('/images/favicon_256.ico')}}" type="image/x-icon">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
        }

        :root {
            --primary-color: #1E1F20;
        }

        html {
            overscroll-behavior: none;
        }

        body {
            overflow: hidden;
        }

        .container {
            position: absolute;
            left: 0;
            top: 0;
            background: var(--primary-color);
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 30px;
        }

        .container .logo {
            position: absolute;
            top: 0;
            left: 0;
            padding: 15px;
            font-size: 1.5em;
            color: #DBDBDB;
            user-select: none;
        }

        .verify-email{
            width: 500px;
            height: 300px;
            background:red;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #DBDBDB;
            background: var(--primary-color);
        }

        .verify-email h1{
            font-size: 2em;
            color: #DBDBDB;
            pointer-events: none;
            user-select: none;
            margin-bottom: 18%;
        }

        .verify-email p{
            line-height: 2;
            color: #DBDBDB;
            font-size: 14px;
        }

        .verify-email .btn{
            margin-top: 15px;
            width: 250px;
            height: 30px;
            border: none;
            outline: none;
            font-size: 1em;
            cursor: pointer;
            border-radius: 20px;
            color: #1E1F20;
            background: #9CB9E8;
            transition: .3s;
        }

         .verify-email .btn:hover {
            color: #DBDBDB;
         }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="logo">TodoList</h1>
        <div class="content">
            <div class="verify-email">
                <h1>Verifique seu e-mail</h1>

                <p>Antes de continuar, por favor verifique seu e-mail {{ Auth::user()->email }}. Se você não recebeu o e-mail, clique abaixo para reenviar.</p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn">Reenviar link de verificação</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

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