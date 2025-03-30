@extends('layout.app')

@section('title')
    + Add Expense
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-md-10 col-sm-6">
            <h4 class="page-title">Add Expense</h4>
        </div>
        <div class="col-md-2 col-sm-6 text-end">
            <h4 class="page-title">
                <a href="{{ route('expenses') }}" class="btn btn-success w-100">
                    + All Expenses
                </a>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
            <!-- @include('include.alert') -->
                <form class="form-horizontal" method="post" action="{{route('save-expense')}}">
                @csrf
                    <div class="form-group mb-3 col-sm-12 col-md-6">
                        <label for="category">Expense Category</label>
                        <select id="category" class="form-control " name="expense_category">
                            <option value="general">General</option>
                            <option value="petrol">Petrol</option>
                            <option value="food">Food</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 col-sm-12 col-md-6">
                        <label for="amount">Amount*</label>
                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount" 
                        value="{{ old('amount') }}">
                        @error('amount')
                            <ul class="parsley-errors-list filled"  aria-hidden="false">
                                <li class="parsley-required">{{ $message}}</li>
                            </ul>
                        @enderror
                    </div>
                    <div class="form-group mb-3 col-sm-12 col-md-6">
                        <label for="expensedate">Expense Date*</label>
                        <input type="datetime-local" id="expensedate" 
                            class="form-control @error('entrydate') parsley-error @enderror" 
                            name="entrydate" value="{{ old('entrydate') }}" 
                            required placeholder="Enter Date">
                    </div>
                    <div class="form-group mb-3 col-sm-12 col-md-6">
                        <label for="description">Note</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <div class="form-group mb-3 col-sm-12 col-md-6">
                        <input type="submit" class="btn btn-primary waves-effect waves-light" value="Save">
                        <input type="reset" class="btn btn-danger waves-effect waves-light ml-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection