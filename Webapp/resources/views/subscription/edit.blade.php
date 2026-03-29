@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <form action="{{ route('subscription.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $subscription->name }}">
        <input type="email" name="email" value="{{ $subscription->email }}">
        <input type="text" name="street" value="{{ $subscription->street }}">
        <input type="text" name="number" value="{{ $subscription->number }}">
        <input type="text" name="zip_code" value="{{ $subscription->zip_code }}">
        <input type="text" name="city" value="{{ $subscription->city }}">
        <input type="text" name="country" value="{{ $subscription->country }}">

        <button type="submit">Bijwerken</button>
    </form>
@endsection
