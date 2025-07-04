<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>To do list app</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('/images/favicon_256.ico')}}" type="image/x-icon">
</head>


<body>
    <div class="navbar-top">
        <div class="menu">
            <span class="menu-icon"><i class='bx bx-menu'></i></span>
            <h1>To do List</h1>
        </div>

        <div class="info">
            <div class="search">
                <form class='form-search' data-send="false" action="{{route('category.index')}}">
                    <label class="icon-search"><i class='bx bx-search'></i></label>
                    <div class="input-box">
                        <button><i class='bx bx-search'></i></button>
                        <input type="text" name="s" placeholder="Pesquisar">
                        <select name="option">
                            <option disabled>Filtro</option>
                            <option selected value="category">listas</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="info-icons">
                <a href="{{route('user.edit')}}"><i class='bx bx-cog'></i></a>
            </div>
            <div class="profile">
                <div class="img">
                    <img src="{{asset(Auth::user()->image)}}">
                </div>
            </div>

        </div>
    </div>
    <aside>
        <nav class="navbar-side">
            <button class="aside-btn-task"><i class='bx bx-plus'></i>Criar</button>
            <a href="{{route('category.index')}}" class="thing-all"><i class='bx bx-chevron-down-circle'></i>Todas as tarefas</a>
            <div class="dropdown">
                <div class="select">
                    <span class="selected">Listas</span>
                    <div class="caret"></div>
                </div>
                <ul class="menu">
                    @foreach($categories as $category)
                    <li class="list__id check" data-id="{{$category->id}}">
                        <div><span class="checkbox"></span>
                            <span class="menu-item-text">{{$category->name}}</span></div>
                        <span class="count">{{$category->tasks()->count()}}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <span class="thing-all aside-btn-category"><i class='bx bx-plus'></i>Criar nova lista</span>
            <a href="{{url('/sair')}}" class="loggout"><i class='bx bxs-door-open'></i>Sair</a>

        </nav>
    </aside>

    <div class="content">
        @yield('content')
    </div>

    <div class="form-create-task">
        <div class="form-create">
            <div class="icon-close">
                <span><i class='bx bx-x'></i></span>
            </div>
            <form action="{{ route('tasks.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="input-box">
                    <span class="icon"></span>
                    <input type="text" name="name" autocomplete="off" placeholder="Adicionar título">
                </div>
                <div class="textarea-box">
                    <span class="icon"><i class='bx bx-menu-alt-left'></i></span>
                    <div>
                        <textarea name="description" placeholder="Descrição" autocapitalize="true"></textarea>
                    </div>
                </div>
                <div class="select-box">
                    <span class="icon"><i class='bx bx-calendar'></i></span>
                    <select name="category_id">
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-task">
                    <button class="btn">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="leaving-container">
        <div class="leaving-task">
            <span class="leaving-task-title">Rejeitar as alterações não guardadas?</span>
            <div class="btn-leaving">
                <span class="btn keep">Cancelar</span>
                <span class="btn leave">Rejeitar</span>
            </div>
        </div>
    </div>

    <div class="form-create-category">
        <div class="form-create">
            <div class="category-title">
                <h3>Criar nova lista</h3>
            </div>
            <form action="{{route('category.store')}}" method="post">
                @csrf
                @method('POST')
                <div class="input-box">
                    <input type="text" name="name" placeholder="Introduzir nome">
                </div>
                <div class="message-category">
                    <span class="message-category-error">O nome da lista de tarefas não pode estar vazio.</span>
                </div>

                <div class="btn">
                    <span class="cancel">Cancelar</span>
                    <button type="submit" class="submit">Concluido</button>
                </div>
            </form>
        </div>
    </div>

    <div class="ajax-response {{session('message_flash') ? 'active' : ''}}">
        <span class="ajax-response__message">{{session('message_flash')}}</span>
    </div>
 <script src="{{asset('js/script.js')}}"></script>
</body>

</html>