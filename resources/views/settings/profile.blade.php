@extends('layouts._theme')

@section('title', 'Definições')


@section('content')
<div class="settings">
    <div class="settings__head">
        <span>Definições</span>
    </div>

    <div class="settings__content">
        <div class="settings__content__form">
            <form action="{{route('user.update', ['user' => $user])}}" method="post" enctype="multipart/form-data" data-send="false">
                @csrf
                @method('PUT')
                <div class="form__text">
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{old('email', $user->email)}}" id="email">
                    </div>
                    @error('email')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>    
                        @enderror
                    <div class="input-box">
                        <label for="password">Senha</label>
                        <input type="text" name="password" id="passsword" value="">
                    </div>
                    @error('password')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="input-box">
                        <label for="password__confirm">Confirme Senha</label>
                        <input type="text" name="password_confirmation" id="password__confirm">
                    </div>
                </div>
                <div class="form__others">
                    <label for="file">
                        <img src="{{asset($user->image)}}" class="form__img" alt="foto de perfil">
                        <input type="file" accept="image/jpeg, image/png, image/jpg" name="photo" id="file">
                    </label>
                    @error('photo')
                    <p class="message error">
                        <i class='bx bx-error-circle'></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <button class="btn-update">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection