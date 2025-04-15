@extends('layouts._theme')

@section('title', 'editando categoria')

@section('content')

<form action="{{ route('category.update', ['category' => $category]) }}" method="post">
        @method('PUT')
        @csrf
        <input type="text" name="name" value="{{ old('name') ?? $category->name }}" placeholder="Category Name">
        <textarea name="description"> {{old('description') ?? $category->description }} </textarea>
        <input type="text" name="user_id" value="1" readonly> 
        <button type="submit">Actualizar</button>
</form>

@endsection