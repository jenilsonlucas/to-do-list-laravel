<ul>

    <li>{{$category->name}}</li>
    <li>{{$category->description}}</li>
    <li><a href="{{ route('category.edit', ['category' => $category->id]) }}">Editar categoria</a></li>
    <li><a href="{{ route('category.show', ['category' => $category->id]) }}">Ver detalhes</a></li>
    <li>
        <form action="{{ route('category.destroy', ['category' => $category->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
        </form>
    </li>

</ul>