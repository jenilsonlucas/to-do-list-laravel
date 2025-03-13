
@extends('layouts._theme')

@section('title', 'Categories')

@section('content')

<h2>todas categorias</h2>
@each('category-list', $categories, 'category')

@endsection