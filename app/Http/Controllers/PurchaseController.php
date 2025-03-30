<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class PurchaseController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $isSold = $request->input('is_sold');
        $year = $request->input('year');
        $storage = $request->input('storage');
        $color = $request->input('color');
        $sortDirection = $request->input('direction', 'desc');
        if ($request->query('download') === 'csv') {
            $fileName = 'stock';
            if ($color)
                $fileName .= ''.$color;
            if ($storage)
                $fileName .= '-'.$storage;
            if ($year)
                $fileName .= '-'.$year;

            $fileName = $fileName.'-.csv';
            // $fileName = $year.'-'.$storage.'-'.$color.'-stock.csv';
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $allPurchases = Purchase::query()
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('id', 'like', "%{$search}%")
                          ->orWhere('imei', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%")
                          ->orWhere('purchase_from', 'like', "%{$search}%");
                    });
                })
                ->when(($isSold != ''), function ($query) use ($isSold) {
                    if ($isSold == 2)
                        $query->where('is_sold', 0);
                    else
                        $query->where('is_sold', 1);
                })
                ->when($year, function ($query) use ($year) {
                    $query->whereYear('purchase_date', $year);
                })
                ->when($storage, function ($query) use ($storage) {
                    $query->where('storage', 'like', "%{$storage}");
                })
                ->when($color, function ($query) use ($color) {
                    $query->where('color', $color);
                })
                ->where('deleted', 0)
                ->orderBy('id', 'asc')
                ->get();

            $callback = function() use ($allPurchases) {
                $file = fopen('php://output', 'w+');

                // Add the CSV header (modify this based on your model)
                fputcsv($file, ['Sr No', 'Purchase Date', 'IMEI', 'Model', 'Storage', 'Color', 'Sell Date', 'Buy From', 'Mobile No', 'Buy Cost', 'Repairing', 'Buy Price', 'Sold', 'Remark'], ';'); // Specify the custom separator (;)

                // Add the data rows
                $sellDate = '';
                $totalCost = $repairingCost = $purchasePrice = 0;
                foreach ($allPurchases as $row) {
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
                    $totalCost += $row->purchase_cost;
                    $repairingCost += $row->repairing_charge;
                    $purchasePrice += $row->purchase_price;
                }
                fputcsv($file, ['', '', '', '', '', '', '', '', '', '', '', '', '', ''], ';');
                fputcsv($file, ['', '', '', '', '', '', '', '', '', $totalCost, $repairingCost, $purchasePrice, '', ''], ';');

                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        } else {
            $allPurchases = Purchase::query()
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('id', 'like', "%{$search}%")
                          ->orWhere('imei', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%")
                          ->orWhere('purchase_from', 'like', "%{$search}%");
                    });
                })
                ->when(($isSold != ''), function ($query) use ($isSold) {
                    if ($isSold == 2)
                        $query->where('is_sold', 0);
                    else
                        $query->where('is_sold', 1);
                })
                ->when($year, function ($query) use ($year) {
                    $query->whereYear('purchase_date', $year);
                })
                ->when($storage, function ($query) use ($storage) {
                    $query->where('storage', 'like', "%{$storage}");
                })
                ->when($color, function ($query) use ($color) {
                    $query->where('color', $color);
                })
                ->where('deleted', 0)
                ->orderBy('id', $sortDirection)
                ->paginate(20);

            $colors = Purchase::select('color')
                ->distinct()
                ->whereNotNull('color')
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('id', 'like', "%{$search}%")
                          ->orWhere('imei', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%")
                          ->orWhere('purchase_from', 'like', "%{$search}%");
                    });
                })
                ->when(($isSold != ''), function ($query) use ($isSold) {
                    if ($isSold == 2)
                        $query->where('is_sold', 0);
                    else
                        $query->where('is_sold', 1);
                })
                ->when($year, function ($query) use ($year) {
                    $query->whereYear('purchase_date', $year);
                })
                ->when($storage, function ($query) use ($storage) {
                    $query->where('storage', 'like', "%{$storage}");
                })
                ->where('deleted', 0)
                ->orderBy('color', 'asc') // Optional: order by color alphabetically
                ->get();
            return view('purchase.purchases', [
                'allPurchases' => $allPurchases,
                'issold' => $isSold,
                'year' => $year,
                'storage' => $storage,
                'sortDirection' => $sortDirection,
                'totalItems' => $allPurchases->total(),
                'colors' => $colors,
                'selectedcolor' => $color
            ]);
        }
    }

    //New purchase form
    public function newPurchase() {
        return view('purchase.newpurchase');
    }

    public function purchaseDetail($id) {
        $purchase = Purchase::findOrFail($id);
        return view('purchase.purchasedetail', ['purchase' => $purchase]);
    }

    public function savePurchase(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'model'=>'required',
            'imei'=>'required',
            'purchase_date'=>'required',
            'color'=>'required',
            'storage'=>'required',
            'purchase_from'=>'required',
            // 'contactno'=>'required|max:12|min:10',
            'purchase_cost'=>'required'
        ], [
            // 'contactno.required' => 'Please Correct Phone Number',
        ]);
        
        $purchase = new Purchase();
        $purchase->device_type = $request->device_type;
        $purchase->model = $request->model;
        // $purchase->brand = $request->brand;
        $purchase->imei = $request->imei;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->color = $request->color;
        $purchase->storage = $request->storage;
        $purchase->purchase_from = $request->purchase_from;
        $purchase->contactno = $request->contactno;
        $purchase->warrentydate = $request->warrentydate;
        $purchase->purchase_cost = $request->purchase_cost;
        $purchase->repairing_charge = $request->repairing_charge;
        
        $repairingCharge = $purchase_price = $purchase->purchase_price = 0;
        if ($purchase->repairing_charge > 0) {
            $repairingCharge = $purchase->repairing_charge;
        }
        if ($purchase->purchase_cost > 0) {
            $purchaseCost = $purchase->purchase_cost;
        }
        $purchase->purchase_price = floatval($purchaseCost + $repairingCharge);
        $purchase->remark = $request->remark;
        $purchase->user_id = Auth::user()->id;

        if ($request->file('document') != null && count($request->file('document')) > 0) {
            foreach ($request->file('document') as $file) {
                // $file = $request->file('document');
                @unlink(public_path('documents/purchases/' . $file->getClientOriginalName()));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('documents/purchases/'), $filename);
                $documents[] = 'documents/purchases/'.$filename;
            }
            $purchase->document = implode(',', $documents);
        }
        $purchase->save();
        return redirect()->route('allpurchases')->withStatus('Stock Added Successfully..');
    }

    public function deleteStock($id, Request $request) {
        // $purchase = Purchase::findOrFail($id);
        // // $purchase->delete();
        // $purchase->deleted = 1; 
        // $purchase->update($purchase->deleted);

        Purchase::where('id', $id)->update(['deleted' => 1]);
        return redirect()->route('allpurchases')->withStatus('Stock Deleted Successfully..');
    }

    public function editPurchase($id) {
        $purchase = Purchase::findOrFail($id);
        return view('purchase.editpurchase', ['purchase' => $purchase]);
    }

    public function updatePurchase(Request $request) {
        $request->validate([
            'model'=>'required',
            'imei'=>'required',
            'purchase_date'=>'required',
            // 'color'=>'required',
            'storage'=>'required',
            'purchase_from'=>'required',
            // 'contactno'=>'required|max:12|min:10',
            'purchase_cost'=>'required',
            // 'document'=>'required',
            'purchase_cost'=>'required',
        ]);
        $purchase = Purchase::findOrFail($request->id);
        $purchase->model = $request->model;
        $purchase->device_type = $request->device_type;
        $purchase->imei = $request->imei;        
        $purchase->purchase_date = $request->purchase_date;
        $purchase->color = $request->color;
        $purchase->storage = $request->storage;
        $purchase->purchase_from = $request->purchase_from;
        $purchase->contactno = $request->contactno;
        $purchase->purchase_cost = $request->purchase_cost;
        $purchase->repairing_charge = $request->repairing_charge;
        $purchase->warrentydate = $request->warrentydate;
        
        $repairingCharge = $purchase_price = $purchase->purchase_price = 0;
        if ($purchase->repairing_charge > 0) {
            $repairingCharge = $purchase->repairing_charge;
        }
        if ($purchase->purchase_cost > 0) { 
            $purchaseCost = $purchase->purchase_cost;
        }
        $purchase->purchase_price = floatval($purchaseCost + $repairingCharge);
        $purchase->remark = $request->remark;
        $purchase->user_id = Auth::user()->id;

        if ($request->file('document') != null && count($request->file('document')) > 0) {
            $purchase->document = $this->uploadFiles($request->file('document'));
        }
        $purchase->update();
        return redirect()->route('allpurchases')->withStatus("Stock Updated Successfully.. :: '".$purchase->model."'");
    }

    // Function for uploading documents
    public function uploadFiles($documents) {
        foreach ($documents as $file) { 
            //  @unlink(public_path('documents/purchases/' . $file->getClientOriginalName()));
            $filename = time() . $file->getClientOriginalName();
            $file->move(public_path('documents/purchases/'), $filename);
            $docs[] = $filename;
        }
        return implode(',', $docs);
    }

    public function importStocks() {
        return view('purchase.import');
    }

    public function downloadStock(Request $request) {
        dd($_REQUEST);
        echo "Download Stocks";
        die;
    }

    public function importStocksData(Request $request) {
        $request->validate([
            'stockdata' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('stockdata');

        if (($handle = fopen($file, 'r')) !== false) {
            fgetcsv($handle, 1000, ';');
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                if ($data[8]) {
                    $is_sold = 1;
                } else {
                    $is_sold = 0;
                }
                Purchase::create([
                    'purchase_date' => \DateTime::createFromFormat('d.m.Y', $data[1])->format('Y-m-d'),
                    'imei' => $data[2],
                    'model' => $data[3],
                    'storage' => $data[4],
                    'color'=> $data[5],
                    'purchase_from'=> $data[6],
                    'contactno' => ($data[7])?$data[7]:null,
                    'purchase_cost' => trim(($data[9])?$data[9]:0),
                    'repairing_charge' => trim($data[10]?$data[10]:0),
                    'remark' => $data[11],
                    'purchase_price' => trim( $data[12]),
                    'user_id' => Auth::user()->id,
                    'device_type' => 'Phone',
                    'is_sold' => $is_sold,
                ]);
            }
            fclose($handle);
        }
        // Excel::import(new ProductsImport, $file);
        // dd($request);
        return redirect()->route('allpurchases')->withStatus('Stocks imported successfully.');
        // die;
    }
}
