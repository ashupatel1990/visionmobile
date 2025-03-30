@extends('layout.app')

@section('title')
    Purchase Report
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Purchases Report</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-3">
            <a href="{{ route('buy-export')}}" class="btn btn-primary"><i class="mdi mdi-file-excel-box"></i> Download Buy Excel</a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-sm-12 col-md-3">
            <div class="card card-pricing card-pricing-recommended">
                <div class="card-body text-center" style="padding: 0.5rem;">
                    <p class="card-pricing-plan-name font-weight-bold text-uppercase" style="padding-bottom:0;">Total Purchase - {{$timePeriod}}</p>
                    <h3 class="text-white">{{$totalPurchaseAmount}}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection