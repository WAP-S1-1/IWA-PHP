@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('partials.commercial-sidebar')
        @include('subscription.subscription-table')
    </div>

@endsection
