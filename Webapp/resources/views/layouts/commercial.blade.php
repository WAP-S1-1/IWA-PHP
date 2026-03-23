@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg m-2 rounded-5"
         style="width:15%;height:100%; background-color:rgba(255,255,255,0.7)">
        <div class="d-flex align-items-start">
            <img class="align-self-start my-3" style="height:75px" src="{{asset('placeholderprofile')}}" alt="profile">
            <div class="media-body">
                <p class="my-3 e-4 align-self-baseline">#123435</p>
                <b class="y-3 align-self-baseline" style="font-size: larger"> User Name </b>
            </div>
        </div>
        <hr style="width:80%; margin-right:auto; margin-left: auto">
        <div class="d-flex align-items-start  align-middle">
            <img class="align-self-start m-3" style="height:50px" src="{{asset('subscription.svg')}}" alt="companies">
            <div class="media-body d-flex flex-column">
                <b class="mt-3" style="font-size: larger"> Bedrijven </b>
            </div>
        </div>
        <div class="ms-4 align-middle">
            <p class=" align-self-baseline">Overzicht</p>
            <p class=" align-self-baseline">Bijwerken</p>
            <p class=" align-self-baseline">Toevoegen</p>
        </div>
        <div class="d-flex align-items-start align-middle">
            <img class="align-self-start m-3" style="height:50px" src="{{asset('subscription.svg')}}" alt="companies">
            <div class="media-body d-flex flex-column">
                <b class="mt-3" style="font-size: larger"> Abonnementen </b>
            </div>
        </div>
        <div class="ms-4 align-middle">
            <p class=" align-self-baseline">Overzicht</p>
            <p class=" align-self-baseline">Bijwerken</p>
            <p class=" align-self-baseline">Toevoegen</p>
        </div>
    </div>
@endsection

