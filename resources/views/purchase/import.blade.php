@extends('layout.app')


@section('title')
    Import Stock Data
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="page-title-box">
                <h2 class="page-title font-weight-bold text-uppercase">Import Stocks</h2>
            </div>
        </div>  
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('include.alert')

                    <hr>
                    <form action="{{ route('purchase.import') }}" enctype="multipart/form-data" method="post" class="@if(count($errors)) was-validated @endif">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-4">
                                <label for="file" class="col-4 col-form-label">Import Stocks*:</label>
                                <div class="col-8">
                                    <input name="stockdata" class="form-control" type="file"  id="file" required>
                                </div>
                                @error('stockdata')
                                    <div class="invalid-feedback">{{ $message}} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <a class="btn btn-danger float-right mb-2 ml-2" href="{{ route('allinvoices') }}">
                                    <i class="mdi mdi-keyboard-backspace"></i>Cancel</a>
                                <button type="submit" class="btn btn-primary float-right mb-2 ml-2">IMPORT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection