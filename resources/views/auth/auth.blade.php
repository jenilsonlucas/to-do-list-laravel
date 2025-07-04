<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação</title>
    <link rel="shortcut icon" href="{{asset('/images/favicon_256.ico')}}" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

        .content-auth {
            position: absolute;
            left: 0;
            top: 0;
            background: var(--primary-color);
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-direction: column;
            gap: 15px;
        }

        .content-auth .logo {
            position: absolute;
            top: 0;
            left: 0;
            padding: 15px;
            font-size: 1.5em;
            color: #DBDBDB;
            user-select: none;
        }

        .form-auth {
            width: 350px;
            
        }

        .form-auth .form-box {
            width: 100%;
        }

        .form-auth.active .form-box.login {
            display: none;
        }

        .form-auth.active .form-box.register {
            margin-top: 10px;
            display: block;
        }

        .form-auth .form-box.login {
            display: block;
        }

        .form-auth .form-box.register {
            display: none;
        }

        .form-auth .form-box .form-title {
            font-size: 1.8em;
            font-weight: 500;
            color: #DBDBDB;
            margin-bottom: 5px;
            padding: 0px 30px;
            pointer-events: none;
            user-select: none;
            text-align: center;
        }

        .form-auth .form-box .input-box {
            position: relative;
            margin-bottom: 20px;
            height: 50px;
        }

        .form-auth .form-box .input-box input {
            border: none;
            outline: none;
            width: 100%;
            height: 100%;
            border-radius: 50px;
            padding: 0px 20px;
            font-size: 1em;
            color: #DBDBDB;
            background: #282928;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, .1);
        }

        .form-auth .form-box .input-box input:focus~label,
        .form-auth .form-box .input-box input:not(:placeholder-shown)~label {
            top: -1px;
            color: #9CB9E8;
            background: var(--primary-color);
        }

        .form-auth .form-box .input-box input:focus,
        .form-auth .form-box .input-box input:not(:placeholder-shown) {
            border-color: #9CB9E8;
            background: var(--primary-color);
        }

        .form-auth .form-box .input-box.error input:focus~label,
        .form-auth .form-box .input-box.error input:not(:placeholder-shown)~label {
            color: #C69795;
        }

        .form-auth .form-box .input-box.error input {
            border-color: #C69795;
        }

        .form-auth .form-box .input-box label {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
            font-size: 1em;
            font-weight: 500;
            pointer-events: none;
            color: #40444A;
            transition: .3s;
            z-index: 3;
        }

        .form-auth .form-box .remember-forgot {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-box .remember-forgot label {
            color: #DBDBDB;
            font-size: 14.5px;
            font-weight: 500;
        }

        .form-box .remember-forgot label input {
            margin-right: 5px;
            accent-color: #9CB9E8;
        }

        .form-auth .form-box .btn {
            width: 100%;
            height: 50px;
            border-radius: 50px;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            background: #000;
            color: #DBDBDB;
            font-weight: 400;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .form-auth .form-box .form-link {
            text-align: center;
            font-size: 1em;
            color: #DBDBDB;
            font-weight: 400;
        }

        .form-auth .form-box .form-link span {
            cursor: pointer;
            color: #9CB9E8;
            font-weight: 700;
            user-select: none;
        }

        .midia-options .btn {
            display: inline-block;
            width: 350px;
            height: 50px;
            border-radius: 50px;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 0.9em;
            background: #282928;
            color: #DBDBDB;
            font-weight: 400;
            cursor: pointer;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            padding: 8px 20px;
        }

        .midia-options .midia-title {
            display: inline-block;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            font-size: 1em;
            font-weight: 400;
            color: #DBDBDB;
        }

        .midia-options .btn .logo-media {
            width: 20px;
            height: 20px;
            object-fit: cover;
            margin-right: 12px;
        }

        .midia-options{
            margin-bottom: 10px;
        }

        .message {
            font-size: 0.9em;
            margin-bottom: 10px;
            margin-top: -20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .message.error {
            color: #C69795;
        }
    </style>
</head>

<body>
    <div class="content-auth">
        <h1 class="logo">TodoList</h1>

        <div class="form-auth {{ $showRegister ? 'active' : ' '}}">

            <div class="form-box login">
                <div class="form-title">
                    <p>Que bom que você voltou</p>
                </div>
                <form action="{{ url('/login') }}" data-send="false" method="post">
                    @csrf
                    <div class="input-box">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder=" " required>
                        <label>Endereço de e-mail</label>
                    </div>
                    @if(session('credentials'))
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ session('credentials' )}}
                    </p>

                    @endif
                    <div class="input-box">
                        <input type="password" name="password" placeholder=" " required>
                        <label>Palavra-passe</label>
                    </div>
                    @if(session('credentials'))
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ session('credentials' )}}
                    </p>
                    @endif
                    <div class="remember-forgot">
                        <label><input type="checkbox" name="remember">Lembre - me</label>
                    </div>
                    <div class="form-btn">
                        <button class="btn">Continuar</button>
                    </div>

                    <div class="form-link">
                        <p>Não tem uma conta? <span class="register-link">Cadastrar</span></p>
                    </div>
                </form>
            </div>
            <div class="form-box register">
                <div class="form-title">
                    <p>Criar uma conta</p>
                </div>
                <form action="{{ url('/register')}}" data-send="false" method="post">
                    @csrf
                    <input type="hidden" name="form_type" value="register">
                    <div class="input-box">
                        <input type="text" name="name" placeholder=" " required>
                        <label>Username</label>
                    </div>
                    @error('name')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="input-box">
                        <input type="email" name="email" placeholder=" " required>
                        <label>Endereço de e-mail</label>
                    </div>
                    @error('email')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="input-box">
                        <input type="password" name="password" placeholder=" " required>
                        <label>Palavra-passe</label>
                    </div>
                    @error('password')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="input-box">
                        <input type="password" name="password_confirmation" placeholder=" " required>
                        <label>Confirme palavra-passe </label>
                    </div>
                    @error('password')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="form-btn">
                        <button class="btn">Continuar</button>
                    </div>

                    <div class="form-link">
                        <p>Já tem uma conta? <span class="login-link">Entrar</span></p>
                    </div>
                </form>
            </div>
        </div>
        <div class="midia-options">
            <span class="midia-title">OU</span>
            <a href="{{url('/login/google/redirect')}}" class="btn">
                <img class="logo-media" src="{{ asset('/images/google.png')}}">
                <span>Continuar com o Google</span>
            </a>
        </div>
    </div>

    <script>
        //elementos do formulário de autenticação
        const formAuth = document.querySelector('.form-auth');
        const registerLink = document.querySelector('.register-link');
        const loginLink = document.querySelector('.login-link');
        const message = document.querySelectorAll('.message');

        message.forEach(message => {
            if (message.classList.contains('error')) {
                const inputBox = message.previousElementSibling;
                inputBox.classList.add('error');
            }
        })

        //Formulário de autenticação
        registerLink.addEventListener('click', () => {
            formAuth.classList.add('active');
        })

        loginLink.addEventListener('click', () => {
            formAuth.classList.remove('active');
        })
    </script>
</body>

</html>