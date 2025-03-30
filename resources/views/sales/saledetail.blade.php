@extends('layout.app')
@php
    $expirydate = \Carbon\Carbon::parse($sale->warranty_expiry_date);
    $currentDate = \Carbon\Carbon::now();
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="page-title-box">
                    <h2 class="page-title font-weight-bold text-uppercase">Sales Detail [#{{ $sale->invoice_no}}]</h2>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-xl-10 col-lg-10 col-12">
                    <div class="card d-block">
                        <div class="card-body">
                            <div class="clerfix"></div>
                            <div class="float-right">
                                <div class="form-row">
                                    <div class="col-auto mb-1">
                                        <a href="javascript:history.back();" class="btn btn-sm btn-success"><i class="mdi mdi-keyboard-backspace"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <tbody>
                                        <tr>
                                            @if($sale->item_description)
                                                <th>Item Detail:</th>
                                                <td>{!! nl2br($sale->item_description) !!}</td>
                                            @endif
                                        
                                            @if($sale->customer_name)
                                                <th>Customer Name:</th>
                                                <td>{{ $sale->customer_name }}</td>
                                            @endif
                                        </tr>
                                        
                                        <tr>
                                            @if($sale->payment_type)
                                            <th>Payment Type:</th>
                                            <td>{{ strtoupper($sale->payment_type) }}</td>
                                            @endif
                                            @if($sale->customer_no)
                                                <th>Customer No:</th>
                                                <td>{{ $sale->customer_no }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($sale->invoice_date)
                                                <th>Sale Date:</th>
                                                <td>{{ \Carbon\Carbon::parse($sale->invoice_date)->format('d-m-Y') }}</td>
                                            @endif
                                            @if($sale->warranty_expiry_date)
                                                <th>Warranty Expiry Date:</th>
                                                <td>
                                                    @if($expirydate->lt($currentDate))
                                                    <span class="badge badge-danger text-uppercase">{{ \Carbon\Carbon::parse($sale->warranty_expiry_date)->format('d-m-Y') }}</span>
                                                    @else
                                                    {{ \Carbon\Carbon::parse($sale->warranty_expiry_date)->format('d-m-Y') }}
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($sale->net_amount)
                                                <th>Net Amount:</th>
                                                <td>₹{{ $sale->net_amount }}</td>
                                            @endif
                                            @if($sale->invoice_by)
                                                <th>Sold By:</th>
                                                <td>{{ $soldBy->name }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($sale->profit)
                                                <th>Profit:</th>
                                                <td>₹{{ $sale->profit }}</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endSection