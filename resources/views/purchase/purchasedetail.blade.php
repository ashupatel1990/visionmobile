@extends('layout.app')

@section('title')
    Stock Detail: #{{ $purchase->id }}
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Stock Detail ID : #{{ $purchase->id }}</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="float-right">
                        <div class="form-row">
                            <div class="col-auto">
                                <a href="javascript:history.back()" class="btn btn-sm btn-success"><i class="mdi mdi-keyboard-backspace"></i> Back</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3 mt-0 font-18">{{ $purchase->model }} 
                        <span class="ml-4 badge @if($purchase->is_sold == 1) badge-danger @else badge-success @endif">
                            @if($purchase->is_sold == 1) Sold @else Available @endif</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <!-- stock card -->
            <div class="card d-block">
                <div class="card-body">

                    <!-- <div class="float-right">
                        <div class="form-row">
                            <div class="col-auto">
                                <a href="{{ route('allpurchases') }}" class="btn btn-sm btn-success"><i class="mdi mdi-keyboard-backspace"></i> Back</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3 mt-0 font-18">{{ $purchase->model }} 
                        <span class="ml-4 badge @if($purchase->is_sold == 1) badge-danger @else badge-success @endif">
                            @if($purchase->is_sold == 1) Sold @else Available @endif</span>
                    </h4> -->

                    <div class="clerfix"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered mb-0">
                            <tbody>
                                @if($purchase->device_type)
                                    <tr>
                                        <th>Device Type:</th>
                                        <td>
                                        @if( $purchase->device_type == 'Phone') 
                                            <i class="ti-mobile"></i>
                                        @endif
                                        @if( $purchase->device_type == 'Tablet') 
                                            <i class="ti-tablet"></i>
                                        @endif
                                        @if( $purchase->device_type == 'Laptop') 
                                            <i class="mdi mdi-laptop-mac"></i>
                                        @endif
                                        @if( $purchase->device_type == 'Accessories') 
                                            <i class="mdi mdi-ipod"></i>
                                        @endif
                                        <span class="badge badge-info text-uppercase">{{ $purchase->device_type }}</span></td>
                                    </tr>
                                @endif
                                <!-- @if($purchase->model)
                                <tr>
                                    <th>Model:</th>
                                    <td>{{ $purchase->model }}</td>
                                </tr>
                                @endif -->
                                {{--
                                <tr>
                                    <th>Brand:</th>
                                    <td>{{ $purchase->brand }}</td>
                                </tr>
                                --}}
                                @if($purchase->imei)
                                <tr>
                                    <th>IMEI:</th>
                                    <td>{{ $purchase->imei }}</td>
                                </tr>
                                @endif
                                @if($purchase->storage)
                                <tr>
                                    <th>Storage(GB):</th>
                                    <td>{{ $purchase->storage }}</td>
                                </tr>
                                @endif
                                @if($purchase->color)
                                <tr>
                                    <th>Color:</th>
                                    <td>{{ ucfirst($purchase->color) }}</td>
                                </tr>
                                @endif
                                @if($purchase->purchase_from)
                                <tr>
                                    <th>Purchase From:</th>
                                    <td>{{ ucfirst($purchase->purchase_from) }}</td>
                                </tr>
                                @endif
                                @if($purchase->contactno)
                                <tr>
                                    <th>Mobile No:</th>
                                    <td>{{ $purchase->contactno }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end card-body-->
                
            </div> <!-- end card-->
            <!-- end card-->
        </div> <!-- end col -->
        <div class="col-xl-6 col-lg-6">
            <!-- stock card -->
            <div class="card d-block">
                <div class="card-body">

                    <div class="clerfix"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered mb-0">
                            <tbody> 
                                <tr>
                                    <th>Purchase Cost:</th>
                                    <td>{{ '₹' .number_format($purchase->purchase_cost) }}</td>
                                </tr>
                                <tr>
                                    <th>Repairing Charge:</th>
                                    <td>{{ '₹' .number_format($purchase->repairing_charge) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Cost:</th>
                                    <td>{{ '₹' .number_format($purchase->purchase_price) }}</td>
                                </tr>
                                @if($purchase->remark)
                                <tr>
                                    <th>Remark:</th>
                                    <td>{{ $purchase->remark }}</td>
                                </tr>
                                @endif
                                @if($purchase->condition)
                                <tr>
                                    <th>Condition:</th>
                                    <td>{{ $purchase->condition }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Purchase Date:</th>
                                    <td>
                                        @php
                                            $buydate = $purchase->created_at;
                                            $date = $buydate->format('d/m/Y');
                                        @endphp
                                        {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Purchased By:</th>
                                    <td>
                                        {{ ucfirst($purchase->user->name) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Brand Warrenty:</th>
                                    <td>
                                        @if($purchase->warrentydate)
                                            {{ \Carbon\Carbon::parse($purchase->warrentydate)->format('d-m-Y') }}
                                        @else
                                            Non Warrenty
                                        @endif
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Battery Health(%)</td>
                                    <td>
                                        <div class="row align-items-center no-gutters">
                                            <div class="col-auto">
                                                <span class="mr-2">8%</span>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end card-body-->
                
            </div> <!-- end card-->
            <!-- end card-->
        </div>
    </div>

    @if ($purchase->document != null)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Documents</h4>
                        <div class="row">
                        @foreach(explode(',', $purchase->document) as $row)
                            <div class="col-sm-2">
                                @if (pathinfo($row, PATHINFO_EXTENSION) == 'pdf')
                                    <a href="{{ asset('documents/purchases/'.$row)}}" class="image-popup" title="{{$purchase->model}}"  target="_blank">
                                        <img src="{{ asset('assets/images/pdf-file.svg') }}" style="height:140px" alt="{{$row}}">
                                    </a>
                                @else
                                    <a href="{{ asset('documents/purchases/'.$row)}}" class="image-popup" title="{{$purchase->model}}"  target="_blank">
                                        <img src="{{ asset('documents/purchases/'.$row)}}" class="img-fluid rounded" alt="work-thumbnail" style="height:140px">
                                    </a>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection