@extends('layout.app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-8 col-md-3">
            <div class="page-title-box col-md-10">
                <h4 class="page-title">Add Sale Information</h4>
            </div>
        </div>
        <div class="col-4 col-md-3">
            <div class="page-title-box text-right">
                <h4 class="page-title">
                    <a href="{{ route('allsales') }}" class="btn btn-sm btn-success">
                        <i class="mdi mdi-keyboard-backspace"></i> Back
                    </a>
                </h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            @include('include.alert')
            <div class="card d-block">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('save-sale')}}">
                                @csrf
                                <input type="hidden" name="userid" value="{{ auth()->user()->id }}" />
                                {{--<div class="form-group row mb-3">
                                    <label for="salemodel" class="col-12 col-md-3 col-form-label">Model*</label>
                                    <div class="col-12 col-md-9 p-0">
                                        <select class="form-control border-bottom" id="salemodel" name="stock_id" value="{{old('stock_id')}}" required tabindex="1">
                                            <option value="" selected>-- Please Select Model --</option>
                                            @foreach ($stockModels as $key=>$model)
                                                <option value="{{$model->id}}">{{ $model->model }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                --}}
                                <div class="form-group row mb-3">
                                    <label for="color" class="col-12 col-md-3 col-form-label p-0">IMEI:</label>
                                    <div class="col-12 col-md-9 p-0">
                                        <input type="text" id="salemodelimei" class="form-control" name="imei" 
                                        tabindex="2" placeholder="Enter IMEI.." />
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-3 ">
                                    <label for="customername" class="col-12 col-md-3 col-form-label p-0">Customer Name*</label>
                                    <div class="col-12 col-md-9 p-0">
                                        <input type="text" id="customername" class="form-control" name="customername" 
                                        value="{{ old('customername') }}" required tabindex="3" placeholder="Enter Customer Name">
                                    </div>
                                    @error('customername')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="mobilenumber" class="col-12 col-md-3 col-form-label p-0">Mobile Number*</label>
                                    <div class="col-12 col-md-9 p-0">
                                        <input type="text" id="mobilenumber" class="form-control" name="contactno" 
                                        value="{{ old('contactno') }}" required tabindex="4" placeholder="Enter Mobile Number">
                                    </div>
                                    @error('contactno')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="saleprice" class="col-12 col-md-3 col-form-label p-0">Sale Price:*</label>
                                    <div class="col-12 col-md-9 p-0 input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text">₹</span></span>
                                        <input type="number" id="saleprice" class="form-control" name="saleprice" value="{{ old('saleprice') }}" required tabindex="5" placeholder="Enter Sale Price">
                                    </div>
                                    @error('saleprice')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="paymentmode" class="col-12 col-md-3 col-form-label p-0">Payment Mode*</label>
                                    <div class="col-12 col-md-9 p-0">
                                        <select class="form-control border-bottom" id="model" name="payment_mode" value="{{old('payment_mode')}}" required tabindex="6">
                                            <option value="" selected>-- Select Payment Mode --</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Online">Online</option>
                                            <option value="Credit Card">Card</option>
                                        </select>
                                    </div>
                                    @error('payment_mode')
                                    <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                        <li class="parsley-required">{{ $message}}</li>
                                    </ul>
                                    @enderror
                                </div>
                                <input type="hidden" name="purchaseprice"  id="modelpurchaseprice" value="" />
                                <div class="form-group row mb-3">
                                    <label for="remark" class="col-12 col-md-3 col-form-label"></label>
                                    <div class="col-5">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light col-md-12" tabindex="13"><i class="fe-check-circle mr-1"></i>Save</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="reset" class="btn btn-danger waves-effect waves-light col-md-12" tabindex="14"><i class="fe-x mr-1"></i>Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <div class="card defaulthide">
                                <div class="card-body">
                                    <h4 class="header-title text-uppercase">Model: <span id="device_model"></span></h4>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>Color :</strong> <span class="ml-2" id="model_color"></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>IMEI :</strong> <span class="ml-2" id="imei"></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>Storage :</strong> <span class="ml-2" id="storage"></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>Purchase Cost :</strong> <span class="ml-2" id="purchase_cost"></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>Repairing Charge :</strong> <span class="ml-2" id="repairing_charge"></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13">
                                        <strong>Purchase Price :</strong> <span class="ml-2" id="purchase_price"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="card nodatahide">
                                <div class="card-body">
                                    <h4 class="header-title text-uppercase"><span id="nodatafound"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div> <!-- container -->
<style>
.defaulthide, .nodatahide { display: none; }
</style>
@endSection