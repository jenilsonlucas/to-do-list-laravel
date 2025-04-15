
@extends('layouts._theme')

@section('title', 'Create Category')

@section('content')


<form action="{{ route('category.store') }}" method="post">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Category Name">
        <textarea name="description"> {{old('description') }} </textarea>
        <input type="text" name="user_id" value="1" readonly> 
        <button type="submit">Adicionar nova categoria</button>
</form>

@endsection