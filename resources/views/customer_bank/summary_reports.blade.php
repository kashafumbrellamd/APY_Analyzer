@extends('layouts.admin')

@section('title')
    APY ANALYZER
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('summary-report')
    </div>
@endsection
