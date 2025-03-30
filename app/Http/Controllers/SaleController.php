<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Invoice;
use App\Models\User;

class SaleController extends Controller
{
    //
    public function index(Request $request)
    {
        // $allSales = Sale::where('deleted', 0)->orderBy('saledate', 'desc')->get();
        // echo $count = Purchase::where('is_sold', 0)->count();
        $search = $request->input('search');
        $year = $request->input('year');
        $sortDirection = $request->input('direction', 'desc');
        $netAmoutSort = $request->input('netamoutsort', 'asc');
        $storage = $request->input('storage');
        $paymentType = $request->input('paymentType');
        $allSales = Invoice::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('item_description', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            })
            ->when($storage, function ($query) use ($storage) {
                $query->where('item_description', 'like', "%{$storage}%");
            })
            ->when($paymentType, function($query) use($paymentType) {
                $query->where('payment_type', $paymentType);
            })
            ->where('deleted', 0)
            ->orderBy('id', $sortDirection)
            // ->orderBy('net_amount', $netAmoutSort)
            ->paginate(10);
        // $allSales = Invoice::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('sales.index', [
            'allSales' => $allSales,
            'year' => $year,
            'sortDirection' => $sortDirection,
            'netamoutsort' => $netAmoutSort,
            'storage' => $storage,
            'totalItems' => $allSales->total(),
            'storage' => $storage,
            'paymentType' => $paymentType
        ]);
    }

    public function saleDetail($id) {
        // $sale = Sale::findOrFail($id);
        $sale = Invoice::findOrFail($id);
        // $purchasePrice = Purchase::findOrFail($sale->item_id)->purchase_price;
        $soldBy = User::findOrFail($sale->invoice_by);
        return view('sales.saledetail', ['sale' => $sale, 'soldBy' => $soldBy]);
    }

    public function newSale()
    {
        $stocksModel = Purchase::where('is_sold', 0)->get();
        return view('sales.newsale', ['stockModels' => $stocksModel]);
    }

    public function saveSale(Request $request)
    {
        $stockData = Purchase::findOrFail($request->stock_id);
        $request->validate([
            'customername'=>'required',
            'contactno'=> ['required', 'max:12','min:10'],
            'saleprice' => ['required', 'gt:purchaseprice'],
            'payment_mode' => ['required'],
            'stock_id' => 'required'
        ], [
            'contactno.required' => 'Please Correct Phone Number',
            'saleprice.gt' => 'Sale price must be greater than purchase price.',
        ]);
        
        $sale = new Sale();
        $sale->customername = $request->customername;
        $sale->contactno = $request->contactno;
        $sale->saledate = \Carbon\Carbon::now()->toDateTimeString();
        $sale->model = $stockData->model;
        $sale->saleprice = $request->saleprice;
        $sale->stock_id = $stockData->id;
        Purchase::findOrFail($request->stock_id)->update(['is_sold' => 1]);
        $profit = floatval($request->saleprice - $stockData->purchase_price);
        $sale->profit = $profit;
        $sale->user_id = $request->userid;
        $sale->imei = $stockData->imei;
        $sale->payment_mode = $request->payment_mode;

        $sale->save();
        return redirect()->route('allsales')->withStatus('Sale Added Successfully..');
    }

    public function deleteSale($id) {
        $sale = Invoice::findOrFail($id)->update(['deleted' => 1]);
        $stockId = Invoice::findOrFail($id)->item_id;
        Purchase::findOrFail($stockId)->update(['is_sold' => 0]); // Update stock available
        return redirect()->route('allsales')->withStatus('Sale Deleted Successfully..');
    }

    public function fetchModelData($imei) {
        // $purchase = Purchase::where('imei', $imei)->first();
        $stock = Purchase::where('imei', 'LIKE', "{$imei}%")
            ->where('is_sold', 0)
            ->first();
        $count = $stock ? 1 : 0;
        return response()->json([
            'stock' => $stock,
            'count' => $count
        ]);
    }
}
