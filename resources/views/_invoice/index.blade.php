@extends('layout.app')

@section('title')
    Manage Invoices
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="page-title-box">
                <h2 class="page-title font-weight-bold text-uppercase">Manage Invoices</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        @if (count($allInvoices))
                        <table class="table table-centered mb-0" id="invoice-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="font-weight-bold">Sr No</th>
                                    <th class="font-weight-bold">Invoice No.</th>
                                    <th class="font-weight-bold">Customer Detail</th>
                                    <th class="font-weight-bold">Billing Info</th>
                                    <th class="font-weight-bold">Invoice Date</th>
                                    <th class="font-weight-bold">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($allInvoices as $key=>$invoice)
                                    <tr>
                                        <td><a href="{{route('invoice-detail', $invoice->id)}}"><b>{{ $key+1 }}</b></a></td>
                                        <td>
                                            <a href="{{route('invoice-detail', $invoice->id)}}"><b>#{{ $invoice->invoice_no }}</b></a>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li><b>Name:</b> {{ ucfirst($invoice->customer_name) }} </li>
                                                <li><b>Contact:</b> {{ ucfirst($invoice->customer_no) }} </li>
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
                                        <td>{{ date("d-m-Y", strtotime($invoice->invoice_date)) }}</td>
                                        <td>
                                            <a href="{{route('invoice-edit', $invoice->id)}}" class="btn  btn-blue waves-effect waves-light" title="Update">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="{{route('invoice-detail', $invoice->id)}}" class="btn  btn-blue waves-effect waves-light" title="View">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('print-invoice', $invoice->id) }}"  class="btn btn-success waves-effect waves-light" title="print"><i class="mdi mdi-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <h4>No Invoices Found</h4>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</div>
@endSection