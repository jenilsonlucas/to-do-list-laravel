@extends('layouts._theme')

@section('title', 'Categories')

@section('content')
<div class="tasks-list">
    @foreach($categories as $category)

    <div class="task-item">
        <span id="category-{{$category->id}}" class="list__id" data-id="{{$category->id}}" style="display: none;"></span>
        <div id="task-back-head">
            <div class="task-head">
                <p>{{$category->name}}</p>
                <div class="options">
                    <span class="icon-option">⋮</span>
                    <div class="category-options">
                        <div class="box-options">
                            <span class="change-name" data-id="{{$category->id}}" data-action="{{route('category.update', ['category' => $category])}}">Mudar de nome</span>
                            <span class="delete-task-done" data-id="{{$category->id}}" data-action="{{route('category.tasks.done.destroy', ['category' => $category])}}">Eliminar todas as tarefas concluidas</span>
                            <span class="delete-category {{$category->id == 1 ? 'disable' : ''}}" data-id="{{$category->id}}" data-action="{{route('category.destroy', ['category' => $category])}}">Eliminar a lista</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-task">
                <i class='bx bx-chevron-down-circle'></i><span>Adicionar uma tarefa</span>
            </div>
        </div>
        <div class="task-content"></div>
        @if($category->tasksUndone->isNotEmpty())
        <ul class="task-container first task_container--undone">
            @each('tasks.list', $category->tasksUndone, 'task')
        </ul>
        @elseIf($category->tasksDone->isEmpty())
            @include('tasks.undone')
        @else
            @include('tasks.done')
        @endif

        @if($category->tasksDone->isNotEmpty())
        <div class="task-dropdown"> 
            <div class="select">
                <div class="caret"></div>
                <span class="selected">Concluidas (<span>{{$category->tasksDone()->count()}}</span>)</span>
            </div>
            <ul class="task-container task-container--done">
                @foreach($category->tasksDone as $task)
                @include('tasks.list', ['task' => $task, 'check' => 'checked'])
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @endforeach
</div>


<div class="list-ghost">
    <img src="{{asset('/images/all-task-lists-hidden-dark.svg')}}" alt="todas as listas ocultadas">
    <span>Todas as suas listas estão ocultas</span>
</div>
@endsection