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
        <div class="row p-3">
            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                <p class="mb-0">ID</p>
                <p class="mb-0">Bedrijf</p>
                <hr class="w-100 my-0">
            </div>
            <div class="col-sm-2 m-5 d-flex flex-wrap gap-3">
                <p class="mb-0">Startdatum</p>
                <p class="mb-0">Einddatum</p>
                <hr class="w-100 my-0">
            </div>
            <div class="col-sm-5 m-5 d-flex flex-wrap gap-1" >
                <p class="mb-0">Abonnement</p>
                <p class="mb-0">Omschrijving </p>
                <p class="mb-0">Prijs</p>
                <p class="mb-0">Notities</p>
                <hr class="w-100 my-0">
            </div>
        </div>
        <div class="w-100">
            <div class="row p-5 g-4 justify-content-center">

            </div>
        </div>
    </div>
@endsection

