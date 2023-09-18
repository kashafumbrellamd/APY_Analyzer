@extends('layouts.admin')

@section('title')
    APY ANALYZER
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('view-detailed-customer-bank',['id'=>$id])
    </div>
@endsection
