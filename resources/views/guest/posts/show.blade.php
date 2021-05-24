@extends('layouts.app')

@section('content')
    <h1>{{ $post->titolo }}</h1>
    <p>{{ $post->contenuto }}</p>
    <p>scritto da: {{ $post->user->name }}</p>
@endsection