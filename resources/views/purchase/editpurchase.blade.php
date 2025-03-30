@extends('layout.app')

@section('title')
    Update Stock
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Stock Information! - <span class="badge  badge-success">{{ $purchase->model }}</span></h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            @include('include.alert')
            <div class="card d-block">
                <div class="card-body">
                    <div class="float-right">
                        <div class="form-row">
                            <div class="col-auto">
                                <a href="{{ route('allpurchases') }}" class="btn btn-sm btn-success"><i class="mdi mdi-keyboard-backspace"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('purchase.update', $purchase->id)}}">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="devicetype" class="col-3 col-form-label">Device Type</label>
                                    <div class="col-9">
                                        <select class="form-control" id="devicetype" name="device_type" required value="{{old('device_type')}}">
                                            <option value="Phone" @if(old('device_type')=='Phone') selected @endif>Phone</option>
                                            <option value="Tablet" @if(old('device_type')=='Tablet') selected @endif>Tablet</option>
                                            <option value="Laptop" @if(old('device_type')=='Laptop') selected @endif>Laptop</option>
                                            <option value="Accessories" @if(old('device_type')=='Accessories') selected @endif>Accessories</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="Model" class="col-3 col-form-label">Model</label>
                                    <div class="col-9">
                                        <input type="text" id="model" class="form-control" name="model" value="{{ $purchase->model }}" required>
                                    </div>
                                    @error('model')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                {{--
                                <div class="form-group row mb-3">
                                    <label for="brand" class="col-3 col-form-label">Brand</label>
                                    <div class="col-9">
                                        <input type="text" id="brand" class="form-control" name="brand" value="{{ $purchase->brand }}" required>
                                    </div>
                                    @error('brand')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                --}}    
                                <div class="form-group row mb-3">
                                    <label for="imei" class="col-3 col-form-label">IMEI</label>
                                    <div class="col-9">
                                        <input type="text" id="imei" class="form-control" name="imei" value="{{ $purchase->imei }}" required>
                                    </div>
                                    @error('imei')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="storage" class="col-3 col-form-label">Storage(GB):</label>
                                    <div class="col-9">
                                        <input type="text" id="storage" class="form-control" name="storage" value="{{ $purchase->storage }}" required>
                                    </div>
                                    @error('storage')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="warrentydate" class="col-12 col-md-3 col-form-label">Brand Warrenty:</label>
                                    <div class="col-12 col-md-9">
                                        @if($purchase->warrentydate == null)
                                            <select class="form-control" id="warrenty" name="warrenty" required>
                                                <option value="Non warrenty">Non Warrenty</option>
                                                <option value="Warrenty" {{ $purchase->warrentydate !== null ? 'selected' : '' }}>Warrenty</option>
                                            </select>
                                            <div class="warrenty_date" style="display: none;">
                                                <input type="date" id="warrentydate" class="form-control " name="warrentydate" value="{{ old('warrentydate') }}" 
                                                placeholder="Warrenty Date">
                                            </div>
                                        @else
                                            <div class="warrenty_date">
                                                <input type="date" id="warrentydate" class="form-control " name="warrentydate" value="{{ $purchase->warrentydate }}" 
                                                placeholder="Warrenty Date">
                                            </div>
                                        @endif
                                    </div>
                                    <!-- @error('inwarrenty')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror -->
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="color" class="col-3 col-form-label">Color</label>
                                    <div class="col-9">
                                        <input type="text" id="color" class="form-control" name="color" value="{{ $purchase->color }}">
                                    </div>
                                    @error('color')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="purchasefrom" class="col-3 col-form-label">Party Name:</label>
                                    <div class="col-9">
                                        <input type="text" id="purchasefrom" class="form-control" name="purchase_from" value="{{ $purchase->purchase_from }}" required>
                                    </div>
                                    @error('purchase_from')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="contactno" class="col-3 col-form-label">Party Contact:</label>
                                    <div class="col-9">
                                        <input type="number" id="contactno" class="form-control" name="contactno" value="{{ $purchase->contactno }}">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="purchasedate" class="col-3 col-form-label">Purchase Date:</label>
                                    <div class="col-9">
                                        <input type="date" id="purchasedate" class="form-control" name="purchase_date" value="{{ $purchase->purchase_date }}" required placeholder="Purchase Date">
                                    </div>
                                    @error('purchase_date')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="purchasecost" class="col-3 col-form-label">Purchase Cost(₹):</label>
                                    <div class="col-9">
                                        <input type="number" id="purchasecost" class="form-control" name="purchase_cost" value="{{ $purchase->purchase_cost }}" required placeholder="Purchase Cost">
                                    </div>
                                    @error('purchase_cost')
                                        <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                            <li class="parsley-required">{{ $message}}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="repairing_charge" class="col-3 col-form-label">Repairing Charge(₹):</label>
                                    <div class="col-9">
                                        <input type="number" id="repairing_charge" placeholder="Reapiring Cost" class="form-control" name="repairing_charge" value="{{ $purchase->repairing_charge }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="remark" class="col-3 col-form-label">Remark:</label>
                                    <div class="col-9">
                                        <textarea class="form-control" id="remark" rows="3" name="remark">{{ $purchase->remark }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="document" class="col-3 col-form-label">Documents:</label>
                                    <div class="col-9">
                                        <input name="document[]" class="form-control" type="file"  id="document" multiple>
                                    </div>
                                    @if($purchase->document != '')
                                    @foreach(explode(',', $purchase->document) as $row)
                                        <div class="col-sm-2 mt-4">
                                            <a href="{{ asset('documents/purchases/'.$row)}}" class="image-popup" title="{{$purchase->model}}"  target="_blank">
                                                <img src="{{ asset('documents/purchases/'.$row)}}" class="img-fluid rounded" alt="work-thumbnail">
                                            </a>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="remark" class="col-3 col-form-label"></label>
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light col-md-6"><i class="fe-check-circle mr-1"></i>Update</button>
                                        <a href="{{route('allpurchases')}}" class="btn btn-danger waves-effect waves-light col-md-4"><i class="fe-x mr-1"></i>Cancel</a>
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