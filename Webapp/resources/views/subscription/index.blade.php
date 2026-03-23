@extends('layouts.commercial')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    @parent

    <style>
        #subscriptions > .card {
            display: inline-block;
            vertical-align: top;
        }
    </style>

    <div class="card shadow-lg m-2 rounded-5"
         style="width:82%;height:700px; background-color:rgba(255,255,255,0.7)">
        <div class="d-flex align-items-start">
            <h2 class="my-3 e-4 align-self-baseline">Abonnementen</h2>
    </div>
@endsection

