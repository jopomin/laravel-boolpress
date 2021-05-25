@extends('layouts.dashboard')

@section('content')
    <h1>Dati Utente</h1>
    <ul>
        <li>{{ Auth::user()->name }}</li>
        <li>{{ Auth::user()->email }}</li>
        @if (Auth::user()->api_token)
            <li>
                <li>{{ Auth::user()->api_token }}</li>
            </li>
        @else
            <form action="{{ route('admin.generateToken') }}" method="post">
                @csrf
                <button type="submit">Genera API Token</button>
            </form>
        @endif
    </ul>
@endsection