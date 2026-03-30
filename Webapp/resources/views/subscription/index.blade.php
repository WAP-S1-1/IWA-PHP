@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('partials.side-bar')
        @include('subscription.subscription-table')
    </div>

@endsection
