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
    <div class="no-tasks">
        <img src="{{asset('/images/empty-tasks-dark.svg')}}" alt="">
        <div class="no-tasks-head">
            <h3>Ainda não tem tarefas</h3>
            <p>Adicione tarefas para fazer e monitorize-as no To do List</p>
        </div>
    </div>
</div> 