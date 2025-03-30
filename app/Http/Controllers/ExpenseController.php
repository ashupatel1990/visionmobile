<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    //
    public function index(Request $request)
    {
        // $expenses = Expense::where('deleted', 0)->orderBy('entrydate', 'desc')->get();
        $month = $request->input('month');
        $year = $request->input('year');
        // dd($expenses);
        $currentMonth = Carbon::now()->format('F');
        // $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $query = Expense::where('deleted', 0)->orderBy('entrydate', 'desc');
        if ($month || $year) {
            // Convert month name to number
            $monthNumber = Carbon::parse("1 $month")->month;
            $startOfMonth = Carbon::create($year, $monthNumber, 1)->startOfMonth();
            $endOfMonth = Carbon::create($year, $monthNumber, 1)->endOfMonth();
            $totalExpenseAmount = Expense::whereBetween('entrydate', [$startOfMonth, $endOfMonth])
            ->where('deleted', 0)->sum('amount');
            $query->whereBetween('entrydate', [$startOfMonth, $endOfMonth]);

            $expenses = Expense::whereBetween('entrydate', [$startOfMonth, $endOfMonth])
                ->where('deleted', 0)
                ->get();
        } else {
            $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();
            $totalExpenseAmount = Expense::whereBetween('entrydate', [$startOfMonth, $endOfMonth])
            ->where('deleted', 0)->sum('amount');
            $expenses = Expense::where('deleted', 0)->orderBy('entrydate', 'desc')->get();
        }
        return view('expenses.index', [
            'expenses' => $expenses, 
            'year' => $year ?? date('Y'),
            'month' => $month ?? date('F'),
            // 'timePeriod' => $currentMonth,
            'totalExpenseAmount' => number_format($totalExpenseAmount, 2, '.', ''),
        ]);
    }

    public function addExpense()
    {
        return view('expenses.add');
    }

    public function saveExpense(Request $request) 
    {
        // dd($request);
        $request->validate([
            'amount' => 'required|numeric',
            'entrydate' => 'required|date'
        ]);
        $expense = new Expense();
        $expense->amount = $request->amount;
        $expense->entrydate = $request->entrydate;
        $expense->expense_category = $request->expense_category;
        $expense->description = $request->description;
        $expense->added_by = auth()->user()->id;
        $expense->save();

        return redirect()->route('expenses')->withStatus('Expense Added Successfully..');;
    }

    public function editExpense($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.expenseedit', ['expense' => $expense]);
    }

    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'entrydate' => 'required|date'
        ]);
        $expense = Expense::findOrFail($id);
        $updateData = $request->all();
        $expense->update($updateData);
        return redirect()->route('expenses')->withStatus('Expense Updated Successfully..');
    }

    public function deleteExpense($id)
    {
        Expense::findOrFail($id)->update([
            'deleted' => 1
        ]);
        return redirect()->route('expenses')->withStatus('Expense Deleted Successfully..');
    }
}
