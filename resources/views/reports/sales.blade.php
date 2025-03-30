@extends('layout.app')

@section('title')
    Sales Report
@endsection
@section('content')
<style>.showdefault { display: block !important;}</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Transactions Report [{{$totalItems}}]</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-3">
        <div class="card card-pricing card-pricing-recommended">
            <div class="card-body text-center" style="padding: 0.5rem;">
                <p class="card-pricing-plan-name font-weight-bold text-uppercase" style="padding-bottom:0;">Total Sales - {{$timePeriod}}</p>
                <h3 class="text-white">{{$totalSalesAmount}}</h3>
            </div>
        </div>
    </div>
    {{--<h2 style="line-height: 60px;">&dash;</h2>
    <div class="col-2">
        <div class="card card-pricing card-pricing-recommended">
            <div class="card-body text-center" style="padding: 0.5rem;">
                <p class="card-pricing-plan-name font-weight-bold text-uppercase" style="padding-bottom:0;">Total Purchase</p>
                <h3 class="text-white">{{$totalPurchaseAmount}}</h3>
            </div>
        </div>
    </div> --}}
    <div class="col-12 col-sm-12 col-md-3">
        <div class="card card-pricing" style="background: #08b14a; color:#fff">
            <div class="card-body text-center" style="padding: 0.5rem;">
                <p class="card-pricing-plan-name font-weight-bold text-uppercase" style="padding-bottom:0;">Total Profit - {{$timePeriod}}</p>
                <h3 class="text-white">{{$totalProfitAmount}}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6">
        <form action="{{ route('sale-export') }}" method="GET" id="exportreport" class="mb-3">
            <div class="form-row mb-1">
                <select name="period" class="form-control col-10 col-md-6" id="salesdownloadperiod">
                    <option value="alls" @selected($period == 'alls')>All Sales</option>
                    <option value="thismonth" @selected($period == 'thismonth')>This Month</option>
                    <option value="lastmonth" @selected($period == 'lastmonth')>Last Month</option>
                    <option value="thisyear" @selected($period == 'thisyear')>This Year</option>
                    <option value="custom" @selected($period == 'custom')>Custom</option>
                </select>
                <input type="date" id="fromdate" name="fromdate" class="form-control col-md-3 ml-1" value="" style="display:none;">
                <input type="date" id="todate" name="todate" class="form-control col-md-3 ml-1" value="" style="display:none;">
            </div>
            <input type="submit" value="Download Sales Data" class="btn btn-primary waves-effect waves-light">
        </form>
        <!-- <a href="{{ route('sale-export')}}" class="btn btn-primary"><i class="mdi mdi-file-excel-box"></i> </a> -->
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form action="{{ route('sale-report') }}" method="GET" id="salesreport" class="mb-3">
                <div class="form-row">
                    <select name="period" class="form-control col-12 col-md-4 mb-2 mr-1 mb-md-0" id="selectsalesperiod">
                        <option value="alls" @selected($period == 'alls')>All Sales</option>
                        <option value="thismonth" @selected($period == 'thismonth')>This Month</option>
                        <option value="lastmonth" @selected($period == 'lastmonth')>Last Month</option>
                        <option value="thisyear" @selected($period == 'thisyear')>This Year</option>
                        <option value="lastyear" @selected($period == 'lastyear')>Last Year</option>
                        <option value="custom" @selected($period == 'custom')>Custom</option>
                    </select>
                    <input type="date" id="salefromdate" name="fromdate" class="form-control col-md-2 mr-1 @if($period=='custom') showdefault @endif" value="{{$fromdate}}" style="display:none;">
                    <input type="date" id="saletodate" name="todate" class="form-control col-md-2 @if($period=='custom') showdefault @endif" value="{{$todate}}" style="display:none;">
                    <input type="submit" value="Filter" class="btn btn-primary waves-effect waves-light col-6 col-md-2 mr-1 ml-1">
                    <input type="reset" value="Clear" class="btn btn-danger waves-effect waves-light col-5 col-md-1">
                </div>
            </form>
            <div class="table-responsive">
                @if (count($allSales))
                <table class="table table-centered mb-0" id="invoice-tables">
                    <thead class="thead-light">
                        <tr>
                            <th class="font-weight-bold">Date</th>
                            <th class="font-weight-bold">Invoice No.</th>
                            <th class="font-weight-bold">Party Name</th>
                            <th class="font-weight-bold">Billing Info</th>
                            <th class="font-weight-bold">Payment Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allSales as $key=>$invoice)
                            <tr>
                                <td><b>{{ date("d/m/Y", strtotime($invoice->invoice_date)) }}</b></td>
                                <td>
                                    <a href="{{route('invoice-detail', $invoice->id)}}"><b>#{{ $invoice->invoice_no }}</b></a>
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        @if($invoice->customer_name)<li><b>Name:</b> {{ ucfirst($invoice->customer_name) }} </li>@endif
                                        @if($invoice->customer_no)<li><b>Contact:</b> {{ ucfirst($invoice->customer_no) }} </li> @endif
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        @if($invoice->total_amount)
                                            <li><b>Total Amount:</b> <span>₹{{ $invoice->total_amount }}</span></li>
                                        @endif
                                        @if($invoice->tax_amount)
                                            <li><b>TAX:</b> <span>₹{{ $invoice->tax_amount }}</span></li>
                                        @endif
                                        @if($invoice->discount)
                                            <li><b>Discount:</b> <span>₹{{ $invoice->discount }}</span></li>
                                        @endif
                                        @if($invoice->net_amount)
                                            <li><b>Net Amount:</b> <span>₹{{ $invoice->net_amount }}</span></li>
                                        @endif
                                    </ul>
                                </td>
                                <td>{{ ucfirst($invoice->payment_type) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-links">
                    {{ $allSales->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
                @else
                    <h4>No Transactions to show</h4>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection