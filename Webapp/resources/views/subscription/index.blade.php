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
        .subscription-row {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;   /* 1px looked harsh */
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
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
            <div id="subscriptions-container" class="row g-2">

                    @forelse($subscriptions as $sub)
                    <div class="col-12">
                        <div class="row subscription-row p-2 mx-0">

                            <div class="col-sm-2 d-flex flex-wrap gap-1">
                                <p class="mb-1">{{ $sub->id }}</p>
                                <p class="mb-1">{{ $sub->company_name ?? '' }}</p>
                            </div>

                            <div class="col-sm-2 d-flex flex-wrap gap-1">
                                <p class="mb-0">{{ $sub->start_date }}</p>
                                <p class="mb-0">{{ $sub->end_date ?? '-' }}</p>
                            </div>

                            <div class="col-sm-8  d-flex flex-wrap gap-2">
                                <p class="mb-0">{{ $sub->type_name ?? '' }}</p>
                                <p class="mb-0">{{ $sub->description ?? '' }}</p>
                                <p class="mb-0">€{{ $sub->price }}</p>
                                <p class="mb-0">{{ $sub->notes ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="text-muted">Geen abonnementen gevonden.</p>
                    @endforelse
                </div>
            </div>
        </div>


@endsection

