@extends('layouts._theme')


@section('title', 'detalhes da categoria')


@section('content')
<h1>Detalhes da Categoria</h1>


<p><strong>ID: </strong> {{ $category->id }}</p>
<p><strong>Nome: </strong> {{ $category->name }}</p>
<p><strong>Description: </strong> {{ $category->description }}</p>
<p><strong>Criado em: </strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Actualizado em: </strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>


<a href="{{ url('/') }}"> voltar para todas as categorias</a>

@endsection