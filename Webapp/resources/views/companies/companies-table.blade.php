<style>
    #companies > .card {
        display: inline-block;
        vertical-align: top;
    }
    .companies-box {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
    }
</style>

<div class="card shadow-lg m-2 rounded-5"
     style="width:168vw;height:80vh; background-color:rgba(255,255,255,0.7)">
    <div class="container-fluid px-4 py-3">
        <h1>Overzicht Bedrijven</h1>
        <div class="row justify-content-start">
            <div class="col-md-2">
                <div class="row justify-content-start">
                    <div class="col-md-auto" style="font-weight:bold">ID
                    </div>
                    <div class="col-md-auto" style="font-weight:bold">Bedrijf</div>
                    <hr class="w-100 mx-auto my-2">
                </div>
            </div>
            <div class="col-md-3">
                <div class="row justify-content-center">
                    <div class="col-md-10" style="font-weight:bold">E-mail</div>
                    <hr class="w-75 mx-auto my-2">
                </div>
            </div>
            <div class="col">
                <div class="row justify-content-evenly text-nowrap">
                    <div class="col" style="font-weight:bold">Adresgegevens</div>
                    <hr class="w-80 mx-auto my-2">
                </div>
            </div>
        </div>
        @forelse($companies as $comp)
            <div class="row g-3 mb-2">
                <div class="col-md-2">
                    <div class="companies-box">
                        <div class="row justify-content-evenly text-nowrap">
                            <div class="col-1">{{ $comp->id }}</div>
                            <div class="col-10 text-truncate">{{ $comp->name ?? '' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="companies-box">
                        <div class="row justify-content-evenly">
                            <div class="col-10 text-truncate"> {{ $comp->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="companies-box">
                        <div class="row justify-content-evenly text-nowrap" >
                            <div class="col-6">{{ $comp->street ?? '' }}, {{ $comp->number ?? '' }}</div>
                            <div class="col-5 text-end">{{ $comp->zip_code ?? '' }} {{ $comp->city ?? '' }} {{ $comp->country }}</div>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <p class="text-muted">Geen bedrijven gevonden.</p>
@endforelse
