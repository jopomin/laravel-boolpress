@extends('layouts.app')

@section('content')
    <h1>Tutte le categorie</h1>
    @foreach ($categories as $category)
        <li>
            <a href="{{ route('guest.categories.show', ['slug' => $category->slug]) }}"> {{ $category->name }}</a>
        </li>
    @endforeach
@endsection