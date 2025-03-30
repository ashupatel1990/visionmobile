@extends('layout.app')

@section('title')
    Create Invoice
@endsection
@section('content')

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title font-weight-bold"> CREATE INVOICE : #{{ $lastId }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('include.alert')

                    <h4 class="header-title text-uppercase">Invoice Basic Info: </h4>
                    <hr>
                    <form action="{{ route('create-invoice') }}" method="post" class="@if(count($errors)) was-validated @endif">
                        @csrf
                        <input type="hidden" name="invoice_no" value="{{ $lastId}}"/>
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="salemodel">Item:</label>
                                    <select class="form-control border-bottom @error('item_id') parsley-error @enderror" name="item_id" id="salemodel" required tabindex="1">
                                        <option value="">-- Select Model --</option>
                                        @foreach($stocksModel as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->model }}</option>
                                        @endforeach
                                    </select>
                                    @error('item_id')
                                        <div class="invalid-feedback">{{ $message}} </div>
                                    @enderror
                                </div>
                            </div> -->
                            <input type="hidden" name="item_id" value="" id="itemID"/>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="salemodel">IMEI*:</label>
                                    <input type="text" placeholder="Search IMEI.." name="imei" required class="form-control border-bottom" id="model_imei" tabindex="1">
                                    <ul class="parsley-errors-list filled" id="parsley-id-imei" aria-hidden="false" style="display:none;">
                                        <li class="parsley-required">IMEI Not Found in Stock!</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="customer_name">Customer Name*</label>
                                    <input type="text" required placeholder="Customer Name" name="customer_name" class="form-control border-bottom @error('customer_name') parsley-error @enderror" id="customer_name" tabindex="2" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message}} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="invoicedate">Invoice Date</label>
                                    <input type="date" name="invoice_date" class="form-control border-bottom" id="invoicedate" tabindex="3" value="{{ date('d-m-Y') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="warrantydate">Warrenty Expiry Date</label>
                                    <input type="date" name="warranty_expiry_date" class="form-control border-bottom" id="warrantydate" tabindex="4" value="{{ date('d-m-Y') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="customer_no">Contact No:*</label>
                                    <input type="text" name="customer_no" class="form-control border-bottom" id="customer_no" maxlength="10" tabindex="5" placeholder="Customer mobile">
                                    <!-- @error('customer_no')
                                        <div class="invalid-feedback">{{ $message}} </div>
                                    @enderror -->
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label for="customer_address">Address:</label>
                                    <input type="text" name="customer_address" class="form-control border-bottom " id="customer_address" tabindex="6" placeholder="Customer Address">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="payment_type">Payment Mode:*</label>
                                    <select name="payment_type" class="form-control border-bottom @error('payment_type') parsley-error @enderror" id="payment_type" tabindex="7" required>
                                        <option value="">- Payment Type -</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Online">Online/UPI</option>
                                        <option value="Credit Card">Credit Card</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header-title text-uppercase">Item Details</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 border p-1 text-center">
                                <b>DESCRIPTIONS</b>
                            </div>
                            <div class="col-md-2 border p-1 text-center">
                                <b>QUANTITY</b>
                            </div>
                            <div class="col-md-4 border p-1 text-center">
                                <b>TOTAL AMOUNT</b>
                            </div>
                        </div>

                        <div class="row mb-3">
                                <div class="col-md-6 border p-2">
                                    <textarea rows="5" cols="50" class="form-control @error('item_description') parsley-error @enderror" name="item_description" name="description" id="item_description" tabindex="6"></textarea>
                                </div>
                                <div class="col-md-2 border p-2">
                                    <input type="text" class="form-control text-right " required name="quantity" name="quantity" id="quantity" tabindex="7"/>
                                </div>
                                <div class="col-md-4 border p-2">
                                    <input class="form-control @error('total_amount') parsley-error @enderror text-right" type="text" name="total_amount" id="totalAmountInput" oninput="calculateNetAmount()" tabindex="8" autocomplete="off">
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message}} </div>
                                    @enderror
                                </div>
                            </div>

                        <div class="row mt-0">
                            <div class="col-md-2">
                                <label>CGST (%)</label>
                                <input type="text" class="form-control border-bottom" placeholder="CGST Rate" name="cgst_rate" id="cgst" oninput="calculateNetAmount()" tabindex="9">
                                <span class="float-right gststyle" id="cgstDisplay">0</span>
                                <input type="hidden" id="cgstAmount" name="cgst_amount" value="0">
                            </div>

                            <div class="col-md-2">
                                <label>SGST (%)</label>
                                <input type="text" class="form-control border-bottom" placeholder="SGST Rate" name="sgst_rate" id="sgst" oninput="calculateNetAmount()" tabindex="10">
                                <span class="float-right gststyle" id="sgstDisplay">0</span>
                                <input type="hidden" id="sgstAmount" name="sgst_amount" value="0">
                            </div>

                            <div class="col-md-2">
                                <label>IGST (%)</label>
                                <input type="text" class="form-control border-bottom" placeholder="IGST Rate" name="igst_rate" id="igst" oninput="calculateNetAmount()" tabindex="11">
                                <span class="float-right gststyle" id="igstDisplay">0</span>
                                <input type="hidden" id="igstAmount" name="igst_amount" value="0">
                            </div>
                            <div class="col-md-2">
                                <label>Discount Amount</label>
                                <input type="number" class="form-control border-bottom" placeholder="Discount" name="discount_amount" id="discAmount" oninput="calculateNetAmount()" min="0" tabindex="12">
                                <!-- <span class="float-right gststyle" id="discountDisplay">0</span> -->
                                <!-- <input type="hidden" value="0" name="discount_amount" id="discAmount"/> -->
                            </div>

                            <div class="col-md-4">
                                <ul style="list-style: none;float: right;">
                                    <li>
                                        <b>Total Amount:</b> ₹ <span type="text" id="totalAmountDisplay">0</span>
                                    </li>
                                    <li>
                                        <b>Discount:</b> ₹ <span type="text" id="discountAmount">0</span>
                                    </li>
                                    <li>
                                        <b>Tax:</b> ₹ <span type="text" id="taxDisplay">0</span>
                                        <input type="hidden" value="0" name="tax_amount" id="taxAmount">
                                    </li>
                                    <li>
                                        <b>Net Amount:</b> ₹ <span type="text" id="netAmountDisplay">0</span>
                                        <input type="hidden" value="0" name="net_amount" id="netAmount">
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="declaration" class="form-control border-bottom" id="validationCustom05" placeholder="Declaration">
                                </div>
                                <button type="submit" class="btn btn-primary float-right mb-2 ml-2">SUBMIT</button>
                                <a class="btn btn-danger float-right mb-2 ml-2" href="{{ route('allinvoices') }}"><i class="mdi mdi-keyboard-backspace"></i> Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection