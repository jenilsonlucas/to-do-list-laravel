@extends('layouts._theme')

@section('title', 'Tarefas')

@section('content')

<h3>Mostrando Todas as Tarefas</h3>

@forelse($tasks as $task)

@include('tasks.list', ['task' => $task])

@empty
<p style="font-size:1.2em; color:#fff; background:red; height:30px; 
padding:10px; width:100%; border-radius: 6px;">Sem Nenhuma tarefa</p>

@endforelse

@endsection