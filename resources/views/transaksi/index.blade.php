@extends('layout.temp')
@section('title', 'Transaksi')

@section('content')
    @livewire('LihatTransaksi')
    @livewire('transaksi-component')
    @yield('scripts')
@endsection