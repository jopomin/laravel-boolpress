@extends('layouts.app')

@section('content')
    <h1>Tutti i post</h1>
    @foreach ($posts as $post)
        <li>
            <a href="{{ route('guest.posts.show', ['slug' => $post->slug]) }}"> {{ $post->titolo }}</a>
        </li>
    @endforeach
@endsection