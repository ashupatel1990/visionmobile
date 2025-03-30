<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    //
    public function sale(Request $request)
    {
        $allSales = Invoice::where('deleted', 0)->orderBy('invoice_date', 'desc')->get();
        $period = $request->input('period');
        $totalSalesAmount = $totalProfitAmount = 0;
        $fromDate = $toDate = '';
        if ($period == 'thismonth') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now();  //today's date)
            $allSales = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                ->where('deleted', 0)
                ->orderBy('created_at', 'desc')->paginate(10);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->format('F');
        } elseif ($period == 'lastmonth') {
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();  //today's date)
            $allSales = Invoice::whereBetween('invoice_date', [$lastMonthStart, $lastMonthEnd])
                ->where('deleted', 0)
                ->orderBy('created_at', 'desc')->paginate(10);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [$lastMonthStart, $lastMonthEnd])->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [$lastMonthStart, $lastMonthEnd])->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->subMonth()->format('F');
        } elseif ($period == 'thisyear') {
            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now();  //today's date)
            $allSales = Invoice::whereBetween('invoice_date', [$startOfYear, $endOfYear])
                ->where('deleted', 0)
                ->orderBy('created_at', 'desc')->paginate(10);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [$startOfYear, $endOfYear])->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [$startOfYear, $endOfYear])->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->format('Y');
        } elseif ($period == 'lastyear') {
            $startOfLastYear  = Carbon::now()->subYear()->startOfYear();
            $endOfLastYear  = Carbon::now()->subYear()->endOfYear();
            $allSales = Invoice::whereBetween('invoice_date', [$startOfLastYear, $endOfLastYear])
                ->where('deleted', 0)
                ->orderBy('created_at', 'asc')->paginate(15);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [$startOfLastYear, $endOfLastYear])->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [$startOfLastYear, $endOfLastYear])->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->subYear()->format('Y');
        } elseif ($period == 'custom') {
            $fromDate = $request->input('fromdate');
            $toDate = $request->input('todate');
           // $lastMonthEnd = Carbon::now();  //today's date)
            $allSales = Invoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('deleted', 0)->orderBy('created_at', 'desc')->paginate(15);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->format('F');
        } elseif ($period == 'alls') {
            $allSales = Invoice::where('deleted', 0)
                ->orderBy('created_at', 'desc')->paginate(10);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->format('F');
        } else {
            $allSales = Invoice::where('deleted', 0)
                ->orderBy('created_at', 'desc')->paginate(10);
            $totalSalesAmount = Invoice::whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->where('deleted', 0)->sum('net_amount');
            $totalProfitAmount = Invoice::whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->where('deleted', 0)->sum('profit');
            $timePeriod = Carbon::now()->format('F');
        }
        // $allSales1 = Invoice::whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()])
        //     ->where('deleted', 0)
        //     ->orderBy('created_at', 'desc')->get();
        // $totalSalesAmount = $allSales1->sum('net_amount');
        // $totalProfitAmount = $allSales1->sum('profit');
        return view('reports.sales', [
            'allSales' => $allSales,
            'period' => $period,
            'totalSalesAmount' => number_format($totalSalesAmount, 2, '.', ''),
            'totalProfitAmount' => number_format($totalProfitAmount, 2, '.', ''),
            'fromdate' => $fromDate,
            'todate' => $toDate,
            'totalItems' => $allSales->total(),
            'currentMonth' => Carbon::now()->format('F'),
            'timePeriod' => $timePeriod
        ]);
    }

    /** 
     * Download sales records using route(sale-export) 
     * @param $request
     */
    public function downloadExcel(Request $request)
    {
        $period = $request->input('period');
        $monthName = Carbon::now()->format('F');
        if ($period == 'thismonth') {
            $monthName = Carbon::now()->format('F');
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now();  //today's date)
            $salesReport = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
                ->where('deleted', 0)
                ->orderBy('created_at', 'asc')->get();
        } elseif ($period == 'lastmonth') {
            $monthName = Carbon::now()->subMonth()->format('F');
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();  //today's date)
            $salesReport = Invoice::whereBetween('invoice_date', [$lastMonthStart, $lastMonthEnd])
                ->where('deleted', 0)
                ->orderBy('created_at', 'asc')->get();
        } elseif ($period == 'thisyear') {
            $monthName = Carbon::now()->format('Y');
            $startOfYear = Carbon::now()->startOfYear();
            $endofYear = Carbon::now();
            $salesReport = Invoice::whereBetween('invoice_date', [$startOfYear, $endofYear])
                ->where('deleted', 0)
                ->orderBy('created_at', 'asc')->get();
        } elseif ($period == 'custom') {
            $fromDate = $request->input('fromdate');
            $toDate = $request->input('todate');
            $monthName = date('d-m-Y', time());
            $endofYear = Carbon::now();
            $salesReport = Invoice::whereBetween('invoice_date', [$fromDate, $toDate])
                ->where('deleted', 0)
                ->orderBy('created_at', 'asc')->get();
        } else { 
            $salesReport = Invoice::where('deleted', 0)->orderBy('id', 'asc')->get();
        }
        $fileName = $monthName.'-sales.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
       $callback = function() use ($salesReport) {
            $file = fopen('php://output', 'w+');

            // Add the CSV header (modify this based on your model)
            fputcsv($file, 
                [
                    'ID', 
                    'Invoice No.', 
                    'Sell Date', 
                    'IMEI', 
                    'Model', 
                    'Storage (GB)', 
                    'Color', 
                    'Customer Name', 
                    'Mobile No', 
                    'Sell Price', 
                    'Profit', 
                    'Payment Mode'
                ], 
                ';'
            );

            // Add the data rows
            foreach ($salesReport as $key=>$row) {
                fputcsv($file, [
                    $key+1,
                    $row->invoice_no,
                    $row->invoice_date,
                    $row->purchase->imei,
                    $row->purchase->model,
                    $row->purchase->storage,
                    $row->purchase->color,
                    $row->customer_name,
                    $row->customer_no,
                    $row->net_amount,
                    $row->profit,
                    $row->payment_type
                ], ';');
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function downloadPurchaseExcel()
    {
        // $startOfMonth = Carbon::now()->startOfMonth();
        // $endOfMonth = Carbon::now();
        $allSales = Purchase::query()->orderBy('id', 'asc')->get();

        $fileName = Carbon::now()->format('F').'-Purchase.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $callback = function() use ($allSales) {
            $file = fopen('php://output', 'w+');

            // Add the CSV header (modify this based on your model)
            fputcsv($file, ['Sr No', 'Purchase Date', 'IMEI', 'Model', 'Storage', 'Color', 'Sell Date', 'Buy From', 'Mobile No', 'Buy Cost', 'Repairing', 'Buy Price', 'Sold', 'Remark'], ';'); // Specify the custom separator (;)

            // Add the data rows
            $sellDate = '';
            foreach ($allSales as $row) {
                fputcsv($file, [
                    $row->id, 
                    Carbon::parse($row->purchase_date)->format('d/m/Y'),
                    (string)$row->imei,
                    $row->model,
                    $row->storage,
                    $row->color,
                    ($row->sell_date)?Carbon::parse($row->sell_date)->format('d/m/Y'):'',
                    $row->purchase_from,
                    $row->contactno,
                    $row->purchase_cost,
                    ($row->repairing_charge)?$row->repairing_charge:0,
                    $row->purchase_price,
                    ($row->is_sold == 1)?'Yes':'No',
                    $row->remark
                ], ';');
            }

            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
        // dd($allSales);
    }

    public function downloadPurchaseReport()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now();
        $totalPurchaseAmount = 0;
        $timePeriod = Carbon::now()->format('F');
        $allPurchased = Purchase::where('deleted', 0)->orderBy('created_at', 'desc')->paginate(20);
        $totalPurchaseAmount = Purchase::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->where('deleted', 0)->sum('purchase_cost');
       /* $totalProfitAmount = Purchase::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->where('deleted', 0)->sum('profit');*/
        return view('reports.purchase', [
            'totalPurchaseAmount' => number_format($totalPurchaseAmount, 2, '.', ''),
            'timePeriod' => $timePeriod,
            'allPurchased' => $allPurchased
        ]);
    }

    /**
     * display Sales & profit Charts
     * 
     */
    public function displayCharts()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now();  //today's date)
        $allSales = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
            ->where('deleted', 0)
            ->orderBy('created_at', 'desc')->get();
        $totalSalesAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('net_amount');
        $totalProfitAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('profit');
        $timePeriod = Carbon::now()->format('F');
        // json_encode($allSales);
        return view('reports.saleschart', ['allSales' => json_encode($allSales)]);
    }

    public function customers()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now();  //today's date)
        $uniqueCustomers = Invoice::where('deleted', 0)
            ->select('customer_name', 'customer_no')
            ->distinct()
            ->orderBy('created_at', 'desc')->get();
        // $totalSalesAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('net_amount');
        // $totalProfitAmount = Invoice::whereBetween('invoice_date', [$startOfMonth, $endOfMonth])->where('deleted', 0)->sum('profit');
        // $timePeriod = Carbon::now()->format('F');
        return view('reports.customers', ['customers' => $uniqueCustomers, 'totalcustomers' =>$uniqueCustomers->count()]);
    }

    public function exportcustomers()
    {
        // $startOfMonth = Carbon::now()->startOfMonth();
        // $endOfMonth = Carbon::now();
        $uniqueCustomers = Invoice::where('deleted', 0)
            ->select('customer_name', 'customer_no')
            ->distinct()
            ->orderBy('created_at', 'desc')->get();
        $fileName = 'vision-customers.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $callback = function() use ($uniqueCustomers) {
            $file = fopen('php://output', 'w+');

            // Add the CSV header (modify this based on your model)
            fputcsv($file, 
                [
                    'ID', 
                    'Customer Name', 
                    'Contact Number'
                ], 
                ';'
            );

            // Add the data rows
            foreach ($uniqueCustomers as $key=>$row) {
                fputcsv($file, [
                    $key+1,
                    $row->customer_name,
                    $row->customer_no
                ], ';');
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
