@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('partials.commercial-sidebar')
        @include('companies.companies-table')
    </div>

@endsection
