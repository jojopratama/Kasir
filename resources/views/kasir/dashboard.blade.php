@extends('admin.template.master')
@section('title', "$title")


@section('content')
<div class="content-wrapper d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 100px);">
    <div class="container-fluid">
        <!-- Welcome Message -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="m-0">Selamat Datang, {{ Auth::user()->name }}</h1>
            </div>
        </div>
        
        <!-- Transaction Button -->
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-cash-register"></i> Buat Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
