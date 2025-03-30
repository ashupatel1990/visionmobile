@extends('layout.app')

@section('title')
    Dashboard
@endsection
@section('content')
<style>
.showdefault { display:block !important; } 
</style>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <!-- <form class="form-inline">
                        <a href="javascript: void(0);" class="btn btn-blue btn-sm ml-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-blue btn-sm ml-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form> -->
                    <p style="color: #000;"><i class="mdi mdi-clock font-18 "></i> <b> Date:</b> {{ now()->format('d-m-Y') }} &nbsp;<b>Time:</b> <span id="currentTime"></span></p>
                    <script>
                        function updateTime() {
                            const now = new Date();
                            const hours = String(now.getHours()).padStart(2, '0');
                            const minutes = String(now.getMinutes()).padStart(2, '0');
                            const seconds = String(now.getSeconds()).padStart(2, '0');

                            const currentTime = hours + ":" + minutes + ":" + seconds;
                            document.getElementById('currentTime').innerText = currentTime;
                        }
                        setInterval(updateTime, 1000);
                    </script>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('allpurchases')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-plus-circle font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="mt-1"><span data-plugin="counterup">{{ $stocksInHand }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Stocks in Hand </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-md bg-primary rounded">
                            <i class="fe-calendar avatar-title font-28 text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"> {{ $currentMonthSales }} </span></h3>
                            <p class="text-muted mb-1 text-truncate">{{$currentMonth}} Sales</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-3">
                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                            <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$numberOfProductsSoldInMonth}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Items Sold In <b>{{$currentMonth}}</b></p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                            <i class="fe-dollar-sign font-22 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalSales}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Today's Sales</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
     
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <a href="{{ route('newinvoice') }}" class="btn btn-sm btn-blue waves-effect waves-light float-right">
                    <i class="mdi mdi-plus-circle"></i> Create Invoice
                </a>
                <h4 class="header-title mb-3">Sales Records [{{$totalRecords}}]</h4>
                <form action="{{ route('dashboard') }}" method="GET" class="mb-3" id="dashboardfilter">
                    <div class="form-row">
                        <select name="filtertime" id="findbystatus" class="form-control col-8 col-md-3 mr-1 float-right">
                            <option value="">-- Select Time --</option>
                            <option value="today" @selected($filtertime == 'today')>Today</option>
                            <option value="yesterday" @selected($filtertime == 'yesterday')>Yesterday</option>
                            <option value="lastweek" @selected($filtertime == 'lastweek')>Last Week</option>
                            <option value="month" @selected($filtertime == 'month')>This Month</option>
                            <option value="custom" @selected($filtertime == 'custom')>Custom</option>
                        </select>
                    
                        <input type="date" id="fromdate" name="fromdate" class="form-control col-md-2 @if($filtertime=='custom') showdefault @endif" value="{{$fromdate}}" style="display:none;">
                        <input type="date" id="todate" name="todate" class="form-control col-md-2 @if($filtertime=='custom') showdefault @endif" value="{{$todate}}" style="display:none;">
                        <button type="submit" class="btn btn-primary waves-light col-md-1 col-4">Filter</button>

                    </div>
                </form>
                <div class="table-responsive mt-10">
                    @if (count($todaysSales) )
                    <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Sr.No</th>
                                <th>Item Detail</th>
                                <th>Customer</th>
                                <th>Payment Mode</th>
                                <th>Sale Date</th>
                                <th>Amount</th>
                                <th class="hidden-sm">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todaysSales as $key=>$sale)
                            <tr>
                                <td><a href="{{route('saledetail', $sale->id)}}"><b>#{{ ($todaysSales->currentPage() - 1) * $todaysSales->perPage() + $key + 1 }}</b></a></td>
                                <td>
                                    {{--<ul class="list-unstyled">
                                        <li><b>Model:</b> <span> {{ $sale->item_description }}</span></li>
                                        <li><b>IMEI:</b> <span> {{ $sale->imei }}</span></li>
                                    </ul> --}}
                                    {!! nl2br($sale->item_description) !!}
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><b>Name:</b> <span> {{ $sale->customer_name }}</span></li>
                                        @if($sale->customer_no)<li><b>Contact Number:</b> <span><a href="tel:{{ $sale->customer_no }}"> {{ $sale->customer_no }}</a></span></li>@endif
                                    </ul>
                                </td>
                                <td>
                                    @if( $sale->payment_type == 'Cash')
                                        <span class="badge badge-primary text-uppercase">{{ $sale->payment_type }}</span>
                                    @elseif( $sale->payment_type == 'Online')
                                        <span class="badge badge-info text-uppercase">{{ $sale->payment_type }}</span>
                                    @elseif( $sale->payment_type == 'Credit Card')
                                        <span class="badge badge-warning text-uppercase">{{ $sale->payment_type }}</span>
                                    @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($sale->invoice_date)->format('d/m/Y') }}</td>
                                <td>₹{{ $sale->net_amount }}</td>
                                <td>
                                {{--    <!-- <a href="/" title="Update">
                                        <i class="mdi mdi-square-edit-outline font-18 mr-2 text-muted vertical-middle"></i>
                                    </a> --> --}}
                                    <a href="{{route('saledetail', $sale->id)}}" title="View">
                                        <i class="mdi mdi-eye mr-2 text-muted font-18 vertical-middle"></i>
                                    </a>
                                    <form method="post" action="{{route('delete-sale', $sale->id)}}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="sureToDelete(event)" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-links">
                        {{ $todaysSales->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                    @else
                        <h4>No Sale Found for Today..</h4>
                    @endif
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection