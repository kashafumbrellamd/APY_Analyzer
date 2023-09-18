@extends('layouts.admin')

@section('title')
    APY ANALYZER
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('registered-banks-for-approval')
    </div>
@endsection
