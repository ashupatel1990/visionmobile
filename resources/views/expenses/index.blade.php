@extends('layout.app')

@section('title')
    Expenses List
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-md-10 col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title">Expense Management</h4>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 text-end">
            <div class="page-title-box">
                <h4 class="page-title">
                    <a href="{{ route('add-expense') }}" class="btn btn-success w-100">
                        + Add Expense
                    </a>
                </h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <div class="row">
        <div class="col-12 col-sm-12 col-md-3">
            <div class="card card-pricing card-pricing-recommended">
                <div class="card-body text-center" style="padding: 0.5rem;">
                    <p class="card-pricing-plan-name font-weight-bold text-uppercase" style="padding-bottom:0;">Total Expense - {{$month}}</p>
                    <h3 class="text-white">₹{{$totalExpenseAmount}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success" id="statusMessage">
                {{ session('status') }}
            </div>
            @endif
            <div class="card-box">
                <!-- <h4 class="header-title mb-4">Expenses</h4> -->
                <form action="{{ route('expenses') }}" method="GET" id="filterexpense">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="example-password">Select Year</label>
                            <select name="year" class="form-control right" id="selectyear">
                                <option value="2025" @selected($year == 2025)>2025</option>
                                <option value="2024" @selected($year == 2024)>2024</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="example-password">Select Month</label>
                            <select name="month" class="form-control right" id="selectmonth">
                                <option value="January" @selected($month == 'January')>January</option>
                                <option value="February" @selected($month == 'February')>February</option>
                                <option value="March" @selected($month == 'March')>March</option>
                                <option value="April" @selected($month == 'April')>April</option>
                                <option value="May" @selected($month == 'May')>May</option>
                                <option value="June" @selected($month == 'June')>June</option>
                                <option value="July" @selected($month == 'July')>July</option>
                                <option value="August" @selected($month == 'August')>August</option>
                                <option value="September" @selected($month == 'September')>September</option>
                                <option value="October" @selected($month == 'October')>October</option>
                                <option value="November" @selected($month == 'November')>November</option>
                                <option value="December" @selected($month == 'December')>December</option>
                            </select>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
                    @if(count($expenses) > 0)
                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Amount(₹)</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th class="hidden-sm">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $key=>$expense)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$expense->expense_category}}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{$expense->entrydate}}</td>
                                <td>{{ $expense->description ? $expense->description : '-' }}</td>
                                <td>
                                    <a href="{{route('edit-expense', $expense->id)}}" title="Update">
                                        <i class="mdi mdi-square-edit-outline font-18 mr-2 text-muted vertical-middle"></i>
                                    </a>
                                    <form method="post" action="{{ route('delete-expense', $expense->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="sureToDelete(event)" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>No Expense found..</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        document.getElementById('statusMessage')?.remove();
    }, 5000);
</script>
@endsection