   
<ul>
    <li><strong>ID: </strong>{{ $task->id }}</li>
    <li><strong>Nome: </strong>{{ $task->name }}</li>
    <li><strong>Categoria: </strong>{{ $task->category->name }}</li>
    <li><strong>Descrição: </strong>{{ $task->description }}</li>
    <li><strong>Feito: </strong>{{ $task->completed ? "sim" : "não"}}</li>
    <li><strong>Criado em: </strong>{{ $task->created_at->format('d/m/Y H:i') }}</li>
    <li><strong>Actualizado em: </strong>{{ $task->updated_at->format('/d/m/Y H:i') }}</li>
    <li><a href="{{ route('tasks.edit', ['task' => $task->id]) }}">Editar categoria</a></li>
    <li><a href="{{ route('tasks.show', ['task' => $task->id]) }}">Ver detalhes</a></li>
    <li>
        <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
        </form>
    </li>
</ul>