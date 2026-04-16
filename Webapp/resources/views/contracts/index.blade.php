@extends('layouts.app')

@section('content')
    <div class="d-flex">
    @include('partials.commercial-sidebar')
    @include('contracts.contract-table')
</div>

@endsection
