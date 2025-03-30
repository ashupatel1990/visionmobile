<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/home', function () {
    return view('welcome');
    // return view('auth.login');
});

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});

Route::get('/dashboard', function (Request $request) {
    $stocksInHand = Purchase::where('is_sold', 0)->count();
    // $todaysSale = Sale::whereDate('saledate', date('Y-m-d'))->count(); // number of items sold today
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    $totalSales = 0;
    $totalSales = Invoice::whereDate('invoice_date', $today)->sum('net_amount');

    // find sum of total sales in current month
    // $currentMonthSales = 0;
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now();  //today's date)
    $sevenDaysAgo = Carbon::now()->subDays(7);
    $currentMonthSales = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
        ->where('deleted', 0)
        ->sum('net_amount');
    // return view('sales.index', ['allSales' => $allSales]);
    $filter = $request->input('filtertime');
    $fromdate = $todate = '';
    $fromdate = Carbon::parse($request->input('fromdate'))->startOfDay();
    $todate = Carbon::parse($request->input('todate'))->startOfDay();
    if ($filter == 'yesterday') {
        $invoices = Invoice::whereDate('invoice_date', $yesterday)->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
        // echo $invoices;
    } elseif ($filter == 'lastweek') {
        $invoices = Invoice::whereBetween('invoice_date', [$sevenDaysAgo, $today])->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
    } elseif ($filter == 'month') {
        $invoices = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
    } elseif ($filter == 'custom') {
        $invoices = Invoice::whereBetween('invoice_date', [$fromdate, $todate])->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
    } else {
        $invoices = Invoice::whereDate('invoice_date', $today)->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
    }

    // $todaysSales = Invoice::whereDate('invoice_date', $today)->where('deleted', 0)->orderBy('created_at', 'desc')->get();
    $numberOfProductsSoldInMonth = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                    ->where('deleted', 0)
                    ->count();
    return view('dashboard', [
        'stocksInHand' => $stocksInHand, 
        'totalSales' => number_format($totalSales, 0, '.', ','),
        'currentMonthSales' => number_format($currentMonthSales, 0, '.', ','),
        'currentMonth' => Carbon::now()->format('F'),
        'numberOfProductsSoldInMonth' => $numberOfProductsSoldInMonth,
        // 'todaysSales' => $todaysSales
        'todaysSales' => $invoices,
        'filtertime' => $filter,
        'fromdate' => $fromdate->format('Y-m-d'),
        'todate' => $todate->format('Y-m-d'),
        'totalRecords' => $invoices->total()
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/changepassword', [AdminController::class, 'changePassword'])->name('admin.changepassword');
    Route::put('/admin/reset-password', [AdminController::class, 'newPassword'])->name('reset-password');
    Route::post('/admin/storeprofile', [AdminController::class, 'updateProfile'])->name('store.profile');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/purchases', [PurchaseController::class, 'index'])->name('allpurchases');
    Route::get('/admin/purchase/add', [PurchaseController::class, 'newPurchase'])->name('purchase.create');
    Route::post('/admin/purchase/add', [PurchaseController::class, 'savePurchase'])->name('purchase.store');
    Route::get('/admin/purchase/edit/{id}', [PurchaseController::class, 'editPurchase'])->name('purchase.edit');
    Route::post('/admin/purchase/update/{id}', [PurchaseController::class, 'updatePurchase'])->name('purchase.update');
    Route::delete('/admin/purchase/delete/{id}', [PurchaseController::class, 'deleteStock'])->name('delete-stock');
    Route::get('/admin/purchase-detail/{id}', [PurchaseController::class, 'purchaseDetail'])->name('purchase-detail');
    Route::get('/admin/purchase/import', [PurchaseController::class, 'importStocks'])->name('purchase.importform');
    Route::post('/admin/purchase/importdata', [PurchaseController::class, 'importStocksData'])->name('purchase.import');
    Route::get('/admin/purchase/downloadstock', [PurchaseController::class, 'downloadStock'])->name('purchase.downloadstock');
    

    //Sales Routes
    Route::get('/admin/sales', [SaleController::class, 'index'])->name('allsales');
    Route::get('/admin/sales/edit/{id}', [SaleController::class, 'editSale'])->name('saleedit');
    Route::get('/admin/sales/{id}', [SaleController::class, 'saleDetail'])->name('saledetail');
    Route::get('/admin/sale', [SaleController::class, 'newSale'])->name('new-sale');
    Route::post('/admin/sale', [SaleController::class, 'saveSale'])->name('save-sale');
    Route::delete('admin/sale/delete/{id}', [SaleController::class, 'deleteSale'])->name('delete-sale');

    // AJax request for fetching data in create sale
    Route::get('/admin/fetchstockdata/{id}', [SaleController::class, 'fetchModelData'])->name('fetchmodeldata');

    Route::get('/admin/fetchstockonimei/{imei}', [InvoiceController::class, 'fetchModelData'])->name('fetchmodeldata');

    // Invoices
    Route::get('/admin/invoices', [InvoiceController::class, 'index'])->name('allinvoices');
    Route::get('/admin/invoice/add', [InvoiceController::class, 'newInvoice'])->name('newinvoice');
    Route::post('admin/invoice/create-invoice', [InvoiceController::class, 'createInvoice'])->name('create-invoice');
    Route::get('/admin/invoice/{id}', [InvoiceController::class, 'invoiceDetail'])->name('invoice-detail');
    Route::get('/admin/invoice/print/{id}', [InvoiceController::class, 'printInvoice'])->name('print-invoice');
    Route::get('/admin/invoice/edit/{id}', [InvoiceController::class, 'editInvoice'])->name('invoice-edit');
    Route::post('/admin/invoice/update/{id}', [InvoiceController::class, 'updateInvoice'])->name('invoice-update');

    Route::get('/admin/reports/sales', [ReportController::class, 'sale'])->name('sale-report')->middleware('checkUser');
    Route::get('/admin/reports/excel', [ReportController::class, 'downloadExcel'])->name('sale-export')->middleware('checkUser');
    Route::get('/admin/reports/buyexcel', [ReportController::class, 'downloadPurchaseExcel'])->name('buy-export')->middleware('checkUser');
    Route::get('/admin/reports/purchasereport', [ReportController::class, 'downloadPurchaseReport'])->name('purchase-report')->middleware('checkUser');

    // Expense Management
    Route::get('/admin/expenses', [ExpenseController::class, 'index'])->name('expenses');
    Route::get('/admin/expenses/add', [ExpenseController::class, 'addExpense'])->name('add-expense');
    Route::post('/admin/expenses/save-expense', [ExpenseController::class, 'saveExpense'])->name('save-expense');
    Route::get('/admin/expenses/edit/{id}', [ExpenseController::class, 'editExpense'])->name('edit-expense');
    Route::post('/admin/expenses/update/{id}', [ExpenseController::class, 'updateExpense'])->name('expenseedit');
    Route::delete('/admin/expenses/delete/{id}', [ExpenseController::class, 'deleteExpense'])->name('delete-expense');
    

    Route::get('/admin/reports/salescharts', [ReportController::class, 'displayCharts'])->name('saleschart')->middleware('checkUser');
    Route::get('/admin/reports/customers', [ReportController::class, 'customers'])->name('customers')->middleware('checkUser');
    Route::get('/admin/reports/exportcustomers', [ReportController::class, 'exportcustomers'])->name('exportcustomers')->middleware('checkUser');
    // Route::get('/admin/reports/purchases', [ReportController::class, 'purchase'])->name('purchase-report');
});

require __DIR__.'/auth.php';
