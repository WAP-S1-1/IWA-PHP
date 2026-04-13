<style>
    #users > .card {
        display: inline-block;
        vertical-align: top;
    }
    .users-box {
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
                @if($mode === 'edit')
                    <h1>Gebruikers wijzigen</h1>
                @else
                    <h1>Overzicht Gebruikers</h1>
                @endif
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
            <div class="col-md-2">
                <div class="row justify-content-start">
                    <div class="col-md-auto" style="font-weight:bold">ID</div>
                    <div class="col-md-auto" style="font-weight:bold">Naam</div>
                    <hr class="w-100 mx-auto my-2">
                </div>
            </div>
            <div class="col-md-3">
                <div class="row justify-content-evenly">
                    <div class="col-md-4" style="font-weight:bold">E-mail</div>
                    <hr class="w-75 mx-auto my-2">
                </div>
            </div>
            <div class="col">
                <div class="row justify-content-evenly text-nowrap">
                    @if($mode === 'edit')
                        <div class="col-3" style="font-weight: bold">Rol</div>
                        <div class="col-5" style="font-weight: bold">Omschrijving</div>
                        <div class="col-2" style="font-weight: bold">Werknemerscode</div>
                        <div class="col" style="font-weight: bold">Wijzigen</div>
                        <hr class="w-80 mx-auto my-2">
                    @else
                        <div class="col-3" style="font-weight:bold">Rol</div>
                        <div class="col-6" style="font-weight:bold">Omschrijving</div>
                        <div class="col-2" style="font-weight: bold">Werknemerscode</div>
                        <hr class="w-80 mx-auto my-2">
                    @endif
                </div>
            </div>
        </div>
        @forelse($users as $user)
            <div class="row g-3 mb-2">
                <div class="col-md-2">
                    <div class="users-box">
                        <div class="row justify-content-evenly text-nowrap">
                            <div class="col-1">{{ $user->user_id }}</div>
                            <div class="col-10 text-truncate">{{ $user->first_name ?? '' }} {{ $user->prefix ?? '' }} {{ $user->name }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="users-box">
                        <div class="row justify-content-evenly">
                            <div class="col-11"> {{ $user->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="users-box">
                        <div class="row justify-content-evenly text-nowrap">
                            <div class="col-3">{{ $user->role }}</div>
                            <div class="col-6 text-truncate">{{ $user->description ?? '' }}</div>
                            <div class="col-2 text-end"> {{ $user->employee_code }}</div>
                        </div>
                    </div>
                </div>
                @if($mode === 'edit')
                    <div class="col-md-1">
                        <a href="{{ route('users.edit', $user->user_id) }}"
                           class="btn btn-sm btn-danger" style="height: 24px; padding-top: 0; border-radius: 10px;">
                            Wijzig
                        </a>
                    </div>
                @endif

            </div>
        @empty
            <p class="text-muted">Geen gebruikers gevonden.</p>
@endforelse


