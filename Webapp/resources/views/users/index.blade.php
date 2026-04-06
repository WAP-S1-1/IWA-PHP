@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('partials.users-sidebar')
        @include('users.users-table')
    </div>
@endsection
