@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <h2>Welkom</h2>
    <p>Kies een onderdeel:</p>

    @if(count($menuItems) > 0)
        <ul>
            @foreach($menuItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                    - {{ $item['description'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Er zijn geen onderdelen beschikbaar voor jouw rol.</p>
    @endif
@endsection
