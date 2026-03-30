@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('partials.side-bar')
        @include('companies.companies-table')
    </div>

@endsection
