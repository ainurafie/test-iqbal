@extends('layouts.main')

@section('title')
    Dashboard Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Rekening</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$rekening_count}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-table fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Target</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$target_count}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-table fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Transaksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$transaksi_count}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-table fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
