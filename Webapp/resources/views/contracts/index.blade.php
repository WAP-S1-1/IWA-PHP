@extends('layouts.app')

@section('content')
    <div class="d-flex">
    @include('partials.side-bar')
    @include('contracts.contract-table')
</div>

@endsection
