
@extends('layouts._theme')

@section('title', 'Criar Tarefa')

@section('content')


<form action="{{ route('tasks.store') }}" method="post">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nome da tarefa">
        <select name="category_id">
                <option disabled selected>Categorias</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
        </select>
        <textarea name="description"> {{old('description') }} </textarea>
        <input type="text" name="user_id" value="2" readonly> 
        <button type="submit">Adicionar nova Tarefa</button>
</form>

@endsection