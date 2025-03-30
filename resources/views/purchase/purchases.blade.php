@extends('layout.app')

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">List Purchases</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            @include('include.alert')
            <div class="card-box">
                <a href="{{ request()->fullUrlWithQuery(['download' => 'csv']) }}" class="btn btn-sm btn-primary float-right">
                    <i class="mdi mdi-file-excel-box"></i> Download Stock
                </a>
                <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-blue waves-effect waves-light float-right mr-1">
                    <i class="mdi mdi-plus-circle"></i> Add Stock
                </a>
                @if (count($allPurchases))
                    <h4 class="header-title mb-4">Manage Purchase [{{$totalItems}}]</h4>
                    <form action="{{ route('allpurchases') }}" method="GET" id="filterpurchase">
                        <div class="form-row">
                            <div class="form-group col-md-4 input-group input-group-merge">
                                <input type="text" class="form-control" placeholder="Search ..." name="search" 
                                    value="{{ request()->input('search') }}" id="searchstock">
                                <div class="input-group-append">
                                    <button class="btn btn-dark waves-effect waves-light" type="submit">Search</button>
                                    <!-- <button class="btn btn-danger waves-effect waves-light" type="reset">Reset</button> -->
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="year" class="form-control right" id="selectyear">
                                    <option value="">-- Select Year --</option>
                                    <option value="2025" @selected($year == 2025)>2025</option>
                                    <option value="2024" @selected($year == 2024)>2024</option>
                                    <option value="2023" @selected($year == 2023)>2023</option>
                                    <option value="2022" @selected($year == 2022)>2022</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="storage" class="form-control right" id="selectstorage">
                                    <option value="">-- Storage --</option>
                                    <option value="64" @selected($storage == 64)>64 GB</option>
                                    <option value="128" @selected($storage == 128)>128 GB</option>
                                    <option value="256" @selected($storage == 256)>256 GB</option>
                                    <option value="512" @selected($storage == 512)>512 GB</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="color" class="form-control right" id="selectcolor">
                                    <option value="">-- Color --</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->color }}" @selected(strtolower($color->color) == strtolower($selectedcolor))>{{ $color->color }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="is_sold" class="form-control right" id="findbysold">
                                    <option value="">-- Select Status --</option>
                                    <option value="2" @selected($issold == 2)>Available</option>
                                    <option value="1" @selected($issold == 1)>Sold</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('allpurchases', ['direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Sr.No
                                        @if ($sortDirection == 'asc')
                                            <i class="fa fa-arrow-up"></i>
                                        @else
                                            <i class="fa fa-arrow-down"></i>
                                        @endif
                                        </a>
                                    </th>
                                    <th>Model</th>
                                    <th>Storage(GB)</th>
                                    <th>Color</th>
                                    <th>Buying Cost</th>
                                    <th>Buy Date</th>
                                    <th>Sale Date</th>
                                    <th>Status</th>
                                    <th class="hidden-sm">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($allPurchases as $key=>$purchase)
                                    <tr>
                                        <td><a href="{{route('purchase-detail', $purchase->id)}}"><b>#{{ $purchase->id }}</b></a></td>
                                        <td><a href="{{route('purchase-detail', $purchase->id)}}">{{ ucfirst($purchase->model) }}</a></td>
                                        {{--<td>{{ $purchase->brand }}</td> --}}
                                        <td>{{ $purchase->storage }}</td>
                                        <td>{{ $purchase->color }}</td>
                                        <td>{{ '₹' .number_format($purchase->purchase_price, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}</td>
                                        <td> @if($purchase->sell_date && $purchase->is_sold) {{ \Carbon\Carbon::parse($purchase->sell_date)->format('d-m-Y') }}@else -- @endif</td></td>
                                        <td><span class="badge @if($purchase->is_sold == 1) badge-danger @else badge-success @endif">@if($purchase->is_sold == 1) Sold @else Available @endif</span>
                                        </td>

                                        <td>
                                            @if($purchase->is_sold == 0)
                                            <a href="{{route('purchase.edit', $purchase->id)}}" title="Update">
                                                <i class="mdi mdi-square-edit-outline font-18 mr-2 text-muted vertical-middle"></i>
                                            </a>
                                            @endif
                                            <a href="{{route('purchase-detail', $purchase->id)}}" title="View">
                                                <i class="mdi mdi-eye mr-2 text-muted font-18 vertical-middle"></i>
                                            </a>
                                            <form method="post" action="{{ route('delete-stock', $purchase->id) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="sureToDelete(event)" title="Delete"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-links">
                        {{ $allPurchases->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                    @else
                        <h4>No Stock found..</h4>
                        <a href="{{ route('allpurchases') }}" class="btn btn-sm btn-success waves-effect waves-light">
                            <i class="mdi mdi-keyboard-backspace"></i> Back
                        </a>
                    @endif
            </div>
        </div><!-- end col -->
    </div>
    <!-- end row -->
</div> <!-- container -->

<script>
    function sureToDelete(e){
        if(confirm('Are You sure you want to delete this?')){
            return true;
        }else{
            e.preventDefault();
        }
    }
</script>
@endsection