<style>
    #subscriptions > .card {
        display: inline-block;
        vertical-align: top;
    }
    .contracts-box {
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
                    <h1>Overzicht Contracten</h1>
            </div>
            <div class="col-md-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" style="width: fit-content; align-self: end">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-start">
            <div class="col-md-6">
                <div class="row align-content-around">
                    <div class="col-1 ms-2" style="font-weight:bold">ID</div>
                    <div class="col-5" style="font-weight:bold">Omschrijving</div>
                    <div class="col-3" style="font-weight:bold">Bedrijf</div>
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
            <div class="col-3">
                <div class="row justify-content-evenly text-nowrap">
                        <div class="col-2" style="font-weight:bold">Status</div>
                        <div class="col-1" style="font-weight:bold">Acties</div>
                        <hr class="w-80 mx-auto my-2">
                </div>
            </div>
        </div>
        @forelse($contracts as $con)
            <div class="row g-3 mb-2">
                <div class="col-md-6">
                    <div class="contracts-box">
                        <div class="row align-content-evenly">
                            <div class="col-1 ms-2">{{ $con->id ?? ''}}</div>
                            <div class="col-5 text-truncate">{{ $con->omschrijving ?? '' }}</div>
                            <div class="col-4 text-truncate">{{ $con->company_name ?? '' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="contracts-box">
                        <div class="row justify-content-evenly">
                            <div class="col-4"> {{ $con->start_date }}</div>
                            <div class="col-4"> {{ $con->end_date ?? 'nvt' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="contracts-box">
                        <div class="row justify-content-evenly text-nowrap">
                            <div class="col-2" style="display: flex; align-items: center; justify-content: center;">
                                @if($con->end_date === null || \Carbon\Carbon::parse($con->end_date)->isFuture())
                                    <span class="badge bg-success ">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif</div>
                            <div class="col-1">{{ $con->queries_count ?? 0}}</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Geen contracten gevonden.</p>
@endforelse
