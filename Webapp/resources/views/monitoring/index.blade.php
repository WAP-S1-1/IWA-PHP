@extends('layouts.app')

@section('title', 'Monitoring weerstations')
@section('content')
    <style>
        .stations-card{
            width: 18rem;
            margin: 1rem;
            border-radius: 0.5rem;
            min-height: 260px;
            max-height: 300px;
            overflow: hidden;
        }
        #stations-scroll {
            max-height: 100%;
            overflow-y: auto;
        }

        h2{text-align:center; color:#294B71;padding-top: 21px}
        h1{text-align:center; color:white;padding-top: 21px}
        p{font-weight: bold; color:#294B71 }
    </style>
<div class="card shadow-lg mx-auto mt-5 align-items-center rounded-top-4" style="width:86%;height:10vh;background-color:#262626;">
    <h1>All weatherstations</h1>
</div>
    <div class="card shadow-lg p-4 mx-auto align-items-center rounded-bottom-4"
         style="width:86%; background-color:rgba(255,255,255,0.5)">
        <div id="stations-scroll" class="w-100" style="height:65vh; overflow:hidden; overflow-y:auto;">
            <div id="stations-container" class="row p-4 g-4 justify-content-center"></div>
        </div>
    </div>
@push('scripts')
    <script src="{{ route('assets.weatherstations.js') }}"></script>
    @endpush
@endsection
