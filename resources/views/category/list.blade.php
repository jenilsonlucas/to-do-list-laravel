@extends('layouts._theme')

@section('title', 'Categories')

@section('content')
<div class="tasks-list">
    @foreach($categories as $category)

    <!-- <div class="task-item">
        <div id="task-back-head">
            <div class="task-head">
                <p>{{$category->name}}</p>
                <div class="options">
                    <span class="icon-option" p-title="Opções da lista">⋮</span>
                    <div class="category-options">
                        <div class="box-options">
                            <span class="change-name">Mudar de nome</span>
                            <span class="delete-task-done">Eliminar todas as tarefas concluidas</span>
                            <span class="delete-category">Eliminar a lista</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-task">
                <i class='bx bx-chevron-down-circle'></i><span>Adicionar uma tarefa</span>
            </div>
        </div>
        <div class="task-content"></div>
        <div class="no-tasks">
            <img src="{{asset('/images/empty-tasks-dark.svg')}}" alt="">
            <div class="no-tasks-head">
                <h3>Ainda não tem tarefas</h3>
                <p>Adicione tarefas para fazer e monitorize-as no To do List</p>
            </div>
        </div>
    </div> -->

    <!-- <div class="task-item">
        <div id="task-back-head">
            <div class="task-head">
                <p>{{$category->name}}</p>
                <div class="options">
                    <span class="icon-option" p-title="Opções da lista">⋮</span>
                    <div class="category-options">
                        <div class="box-options">
                            <span class="change-name">Mudar de nome</span>
                            <span class="delete-task-done">Eliminar todas as tarefas concluidas</span>
                            <span class="delete-category">Eliminar a lista</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-task">
                <i class='bx bx-chevron-down-circle'></i><span>Adicionar uma tarefa</span>
            </div>
        </div>
        <div class="task-content"></div>
        <div class="info-checked">
            <div class="img">
                <img src="{{ asset('/images/all-tasks-completed-dark.svg') }}" alt="all task checked">
            </div>
            <div class="info">
                <p>Todas tarefas Concluidas</p>
                <span>Bom trabalho!</span>
            </div>
        </div>
        <div class="task-dropdown">
            <div class="select">
                <div class="caret"></div>
                <span class="selected">Concluidas (5)</span>
            </div>
            <ul class="task-container">
                <li>
                    <div class="info-task">
                        <div class="check checked">
                            <span class="checkbox"></span>
                            <span class="task-text">arrox</span>
                        </div>
                        <div class="task-option">
                            <button class="btn delete"><i class='bx bxs-trash'></i></button>
                        </div>
                    </div>
                    <div class="task-details">
                        <i class='bx bx-menu'></i>
                        <span>Details</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
 -->

    <div class="task-item">
        <div id="task-back-head">
            <div class="task-head">
                <p>{{$category->name}}</p>
                <div class="options">
                    <span class="icon-option" p-title="Opções da lista">⋮</span>
                    <div class="category-options">
                        <div class="box-options">
                            <span class="change-name">Mudar de nome</span>
                            <span class="delete-task-done">Eliminar todas as tarefas concluidas</span>
                            <span class="delete-category">Eliminar a lista</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-task">
                <i class='bx bx-chevron-down-circle'></i><span>Adicionar uma tarefa</span>
            </div>
        </div>
        <div class="task-content"></div>
        <ul class="task-container first">
            <li>
                <div class="info-task">
                    <div class="check">
                        <span class="checkbox"></span>
                        <span class="task-text" contenteditable="false">arrox</span>
                    </div>
                    <div class="task-option">
                        <button class="btn edit"><i class='bx bxs-edit-alt'></i></button>
                        <button class="btn save"><i class='bx bx-save'></i></button>
                        <button class="btn delete"><i class='bx bxs-trash'></i></button>
                    </div>
                </div>
                <div class="task-details">
                    <i class='bx bx-menu'></i>
                    <span>Details</span>
                </div>
                </li=>
            <li>
                <div class="info-task">
                    <div class="check">
                        <span class="checkbox"></span>
                        <span class="task-text" contenteditable="false">arrox</span>
                    </div>
                    <div class="task-option">
                        <button class="btn edit"><i class='bx bxs-edit-alt'></i></button>
                        <button class="btn save"><i class='bx bx-save'></i></button>
                        <button class="btn delete"><i class='bx bxs-trash'></i></button>
                    </div>
                </div>
                <div class="task-details">
                    <i class='bx bx-menu'></i>
                    <span contenteditable="false">Details</span>
                </div>
            </li>
        </ul>
        <div class="task-dropdown">
            <div class="select">
                <div class="caret"></div>
                <span class="selected">Concluidas (5)</span>
            </div>
            <ul class="task-container">
                <li>
                    <div class="info-task">
                        <div class="check checked">
                            <span class="checkbox"></span>
                            <span class="task-text">arrox</span>
                        </div>
                        <div class="task-option">
                            <button class="btn delete"><i class='bx bxs-trash'></i></button>
                        </div>
                    </div>
                    <div class="task-details">
                        <i class='bx bx-menu'></i>
                        <span>Details</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    @endforeach
</div>

@endsection