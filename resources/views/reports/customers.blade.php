@extends('layout.app')

@section('title')
    Customers
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Customers List [{{$totalcustomers}}]</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <a href="{{ route('exportcustomers') }}" class="btn btn-sm btn-primary">
                    <i class="mdi mdi-file-excel-box"></i> Download Customers
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="customers-list">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $customer['customer_name'] }}</td>
                                <td>@if($customer['customer_no'])<a href="tel:{{$customer['customer_no'] }}">{{$customer['customer_no'] }}</a> @else - @endif </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
@endsection