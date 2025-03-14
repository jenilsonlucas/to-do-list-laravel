@extends('layouts._theme')

@section('title', 'actualizar dados da tarefa')


@section('content')


<form action="{{ route('tasks.update', ['task' => $task]) }}" method="post">
    @method('PUT')
    @csrf
    <input type="text" name="name" value="{{ old('name', $task->name)}}" placeholder="Nome da tarefa">
    <select name="category_id">
        <option disabled selected>Categorias</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $task->category_id) == $category->id)>
            {{ $category->name }}
        </option>
        @endforeach
    </select>

    <textarea name="description"> {{old('description', $task->description)}} </textarea>
    <label for="completed">Feito:</label>
    <input type="checkbox" name="completed" @checked(old('completed', $task->completed))>

    <input type="text" name="user_id" value="2" readonly>
    <button type="submit">Adicionar nova Tarefa</button>
</form>


@endsection