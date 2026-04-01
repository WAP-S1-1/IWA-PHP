 <style>
        #subscriptions > .card {
            display: inline-block;
            vertical-align: top;
        }
        .subscription-box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }
    </style>

    <div class="card shadow-lg m-2 rounded-5"
         style="width:168vw;height:fit-content;min-height:80vh; background-color:rgba(255,255,255,0.7)">
        <div class="container-fluid px-4 py-3">
            <div class="row">
                <div class="col">
                    <h1>Overzicht Abonnementen</h1>
                </div>
                <div class="col-md-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" style="width: 300px; align-self: end">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-md-2">
                    <div class="row justify-content-start">
                        <div class="col-md-auto" style="font-weight:bold">ID</div>
                        <div class="col-md-auto" style="font-weight:bold">Bedrijf</div>
                        <hr class="w-100 mx-auto my-2">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row justify-content-evenly">
                        <div class="col-md-4" style="font-weight:bold">Startdatum</div>
                        <div class="col-md-4" style="font-weight:bold"> Einddatum</div>
                        <hr class="w-75 mx-auto my-2">
                    </div>
                </div>
                <div class="col">
                    <div class="row justify-content-evenly text-nowrap">
                        <div class="col-2" style="font-weight:bold">Abonnement</div>
                        <div class="col-6" style="font-weight:bold">Omschrijving</div>
                        <div class="col-1" style="font-weight:bold">Prijs</div>
                        <div class="col-2" style="font-weight:bold">Notities</div>
                        <hr class="w-80 mx-auto my-2">
                    </div>
                </div>
            </div>
            @forelse($subscriptions as $sub)
                <div class="row g-3 mb-2">
                    <div class="col-md-2">
                        <div class="subscription-box">
                            <div class="row justify-content-evenly text-nowrap">
                                <div class="col-1">{{ $sub->id ?? ''}}</div>
                                <div class="col-10 text-truncate">{{ $sub->company_name ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="subscription-box">
                            <div class="row justify-content-evenly">
                                <div class="col-4"> {{ $sub->start_date }}</div>
                                <div class="col-4"> {{ $sub->end_date ?? 'nvt' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="subscription-box">
                            <div class="row justify-content-evenly text-nowrap">
                                <div class="col-2">{{ $sub->type_name ?? '' }}</div>
                                <div class="col-6 text-truncate">{{ $sub->description ?? '' }}</div>
                                <div class="col-1">€{{ $sub->price}}</div>
                                <div class="col-2 text-truncate">{{ $sub->notes ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-muted">Geen abonnementen gevonden.</p>
    @endforelse


