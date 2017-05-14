@extends('layouts.master')

@section('title', 'ABrigham - Oops looks like you found a dead link!')

@section('content')
    <img class="deadLink" src="{{ asset('images/dead-link.png') }}" alt="404 - Oops! you found a Dead Link">
@endsection