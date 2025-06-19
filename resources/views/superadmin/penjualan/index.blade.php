@extends('layouts.app')

@section('title', 'Data Penjualan')
@section('menuSuperadminPenjualan', 'active')

@section('content')
    @livewire('superadmin.penjualan.index')
@endsection
