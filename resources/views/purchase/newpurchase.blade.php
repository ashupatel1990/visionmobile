@extends('layout.app')

@section('title')
    New Stock
@endsection

@section('content')
<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-6">
            <div class="page-title-box col-md-10">
                <h4 class="page-title">Add Stock Information</h4>
            </div>
        </div>
        <div class="col-6">
            <div class="page-title-box col-md-10">
                <h4 class="page-title">
                    <a href="{{ route('allpurchases') }}" class="btn btn-sm btn-success">
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
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('purchase.store')}}">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="devicetype" class="col-12 col-md-3 col-form-label">Device Type</label>
                                    <div class="col-12 col-md-9">
                                        <select class="form-control" id="devicetype" name="device_type" required value="{{old('device_type')}}" tabindex="1">
                                            <option value="Phone" @if(old('device_type')=='Phone') selected @endif>Phone</option>
                                            <option value="Tablet" @if(old('device_type')=='Tablet') selected @endif>Tablet</option>
                                            <option value="Laptop" @if(old('device_type')=='Laptop') selected @endif>Laptop</option>
                                            <option value="Accessories" @if(old('device_type')=='Accessories') selected @endif>Accessories</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="Model" class="col-12 col-md-3 col-form-label">Model*</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="model" class="form-control" name="model" value="{{ old('model') }}" required tabindex="2" placeholder="Enter Model">
                                    </div>
                                    @error('model')
                                        <ul class="parsley-errors-list filled"  aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                {{--
                                <div class="form-group row mb-3">
                                    <label for="brand" class="col-12 col-md-3 col-form-label">Brand*</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="brand" class="form-control @error('brand') parsley-error @enderror" name="brand" value="{{ old('brand') }}" required tabindex="3" placeholder="Enter brand">
                                    </div>
                                    @error('brand')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                --}}
                                <div class="form-group row mb-3">
                                    <label for="imei" class="col-12 col-md-3 col-form-label">IMEI*</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="imei" class="form-control @error('imei') parsley-error @enderror" name="imei" value="{{ old('imei') }}" required tabindex="4" placeholder="Enter IMEI">
                                    </div>
                                    @error('imei')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="storage" class="col-12 col-md-3 col-form-label">Storage(GB):*</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="storage" class="form-control @error('storage') parsley-error @enderror" name="storage" value="{{ old('storage') }}" required tabindex="5" placeholder="Enter Storage"> 
                                    </div>
                                    @error('storage')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="warrenty" class="col-12 col-md-3 col-form-label">Brand Warrenty:</label>
                                    <div class="col-12 col-md-9">
                                        <select class="form-control" id="warrenty" name="warrenty" required>
                                            <option value="Non warrenty" @if(old('warrenty')=='Non warrenty') selected @endif>Non Warrenty</option>
                                            <option value="Warrenty" @if(old('warrenty')=='Warrenty') selected @endif>Warrenty</option>
                                        </select>
                                        <div class="warrenty_date" style="display: none;">
                                            <input type="date" id="warrentydate" class="form-control " name="warrentydate" value="{{ old('warrentydate') }}" 
                                            placeholder="Warrenty Date">
                                        </div>
                                    </div>
                                    <!-- @error('inwarrenty')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror -->
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="color" class="col-12 col-md-3 col-form-label">Color*</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="color" class="form-control" name="color" value="{{ old('color') }}" tabindex="6" placeholder="Enter color">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="purchasefrom" class="col-12 col-md-3 col-form-label">Party Name:</label>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="purchasefrom" class="form-control @error('purchase_from') parsley-error @enderror" name="purchase_from" value="{{ old('purchase_from') }}" required tabindex="7" placeholder="Enter Party">
                                    </div>
                                    @error('purchase_from')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="contactno" class="col-12 col-md-3 col-form-label">Party Contact:</label>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="contactno" class="form-control" name="contactno" value="{{ old('contactno') }}" tabindex="8" placeholder="Enter Party Contact">
                                    </div>
                                    <!-- @error('contactno')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror -->
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="purchasedate" class="col-12 col-md-3 col-form-label">Purchase Date:</label>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="purchasedate" class="form-control @error('purchase_date') parsley-error @enderror" name="purchase_date" value="{{ old('purchase_date') }}" required tabindex="9" placeholder="Enter Purchase Date">
                                    </div>
                                    @error('purchase_date')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="purchasecost" class="col-12 col-md-3 col-form-label">Purchase Cost(₹):</label>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="purchasecost" name="purchase_cost" class="form-control @error('purchase_cost') parsley-error @enderror" name="purchase_cost" value="{{ old('purchase_cost') }}" required tabindex="10" placeholder="Enter Purchase Cost">
                                    </div>
                                    @error('purchase_cost')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="repairing_charge" class="col-12 col-md-3 col-form-label">Repairing Charge(₹):</label>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="repairing_charge" placeholder="Repairing Charge" class="form-control" name="repairing_charge" value="{{ old('repairing_charge') }}" tabindex="11">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="remark" class="col-12 col-md-3 col-form-label">Remark:</label>
                                    <div class="col-12 col-md-9">
                                        <textarea class="form-control" id="remark" rows="3" name="remark" tabindex="12" placeholder="Remark...">{{ old('remark') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="document" class="col-12 col-md-3 col-form-label">Documents:</label>
                                    <div class="col-12 col-md-9">
                                        <input name="document[]" class="form-control" type="file"  id="document" multiple>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <!-- <label for="remark" class="col-3 col-form-label"></label> -->
                                    <div class="col-5">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light col-md-12" tabindex="13"><i class="fe-check-circle mr-1"></i>Save</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="reset" class="btn btn-danger waves-effect waves-light col-md-12" tabindex="14"><i class="fe-x mr-1"></i>Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div> <!-- container -->

@endsection