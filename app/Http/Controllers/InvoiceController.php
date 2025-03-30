<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $allInvoices = Invoice::where('deleted', 0)->orderBy('invoice_date', 'desc')->get();
        return view('invoice.index', ['allInvoices' => $allInvoices]);
    }

    public function newInvoice()
    {
        $stocksModel = Purchase::where('deleted', 0)->orderBy('purchase_date', 'desc')->get();

        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $currentYear = date('Y');
        $nextInvoiceNo = 1; // Default to 1
        if ($lastInvoice) {
            // Extract the year from the last invoice number
            preg_match('/VM(\d{4})/', $lastInvoice->invoice_no, $matches);
            $lastYear = $matches[1] ?? null;

            if ($lastYear == $currentYear) {
                // If the year matches, increment the invoice number
                $lastId = intval(substr($lastInvoice->invoice_no, -4)); // Get the last numeric part
                $nextInvoiceNo = $lastId + 1;
            }
        }

        $formattedNumber = "VM" . $currentYear . str_pad($nextInvoiceNo, 4, '0', STR_PAD_LEFT);
        // $lastId = Invoice::orderBy('id', 'desc')->first();
        // if ($lastId) {
        //     $lastId = $lastId->id;
        // } else {
        //     $lastId = 0;
        // }
        // $nextInvoiceNo = $lastId+1;
        // $formattedNumber = "VM".date('Y')."".str_pad($nextInvoiceNo, 4, '0', STR_PAD_LEFT);
        return view('invoice.add', [
            'stocksModel' => $stocksModel,
            'lastId' => $formattedNumber
        ]);
    }

    public function createInvoice(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'item_id' => 'unique:invoices',
            'item_id' => [
            'required',
                Rule::unique('invoices')->where(function ($query) {
                    $query->where('deleted', 0);
                }),
            ],
            'customer_name' => 'required',
            'item_description' => 'required',
            // 'customer_no' => 'required|max:10',
            'invoice_date' => 'required|date',
            'invoice_no' => 'required',
            'total_amount' => 'required|numeric|min:0',
            'net_amount' => 'required|numeric|min:0',
            'payment_type' => 'required'
        ]);
        $invoice = new Invoice();
        $invoice->item_id = $request->item_id;
        $invoice->item_description = $request->item_description;
        $invoice->customer_name = $request->customer_name;
        $invoice->customer_no = $request->customer_no;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->warranty_expiry_date = $request->warranty_expiry_date;
        $invoice->invoice_no = $request->invoice_no;
        $invoice->total_amount = $request->total_amount;
        $invoice->net_amount = $request->net_amount;
        $invoice->cgst_rate = $request->cgst_rate;
        $invoice->sgst_rate = $request->sgst_rate;
        $invoice->igst_rate = $request->igst_rate;
        $invoice->cgst_amount = $request->cgst_amount;
        $invoice->sgst_amount = $request->sgst_amount;
        $invoice->igst_amount = $request->igst_amount;
        $invoice->declaration = $request->declaration;
        $invoice->tax_amount = $request->tax_amount;
        $invoice->discount = $request->discount_amount;
        $invoice->discount_rate = $request->discount_rate;
        $invoice->quantity = $request->quantity;
        $invoice->payment_type = $request->payment_type;
        $invoice->is_paid = 1;
        $invoice->profit = floatval( $request->net_amount - Purchase::findOrFail($request->item_id)->purchase_price );
        $invoice->invoice_by = auth()->user()->id;
// dd($invoice);
        Purchase::findOrFail($request->item_id)->update([
            'is_sold' => 1,
            'sell_date' => $request->invoice_date
        ]);
        $invoice->save();

        //return redirect()->route('allinvoices')->withStatus('Invoice Created Successfully..');
        return redirect()->route('print-invoice', $invoice->id);
    }

    public function invoiceDetail($id) {
        $invoice = Invoice::findOrFail($id);
        return view('invoice.detail', ['invoice' => $invoice]);
    }

    public function printInvoice($id) { 
        $invoice = Invoice::findOrFail($id);
        $amountInWords = $this->amoutInWords(floatval($invoice->net_amount));
        return view('invoice.print', ['invoice' => $invoice, 'amountInWords' => $amountInWords]);
    }

    public function fetchModelData($imei) {
        // $purchase = Purchase::where('imei', $imei)->first();
        $purchase = Purchase::where('imei', 'LIKE', "{$imei}%")
            ->where('is_sold', 0)
            ->first();
        $count = $purchase ? 1 : 0;
        // return response()->json($purchase);
        return response()->json([
            'purchase' => $purchase,
            'count' => $count
        ]);
    }

    public function editInvoice($id) {
        $invoice = Invoice::findOrFail($id);
        $stocksModel = Purchase::where('deleted', 0)->orderBy('purchase_date', 'desc')->get();
        return view('invoice.edit', ['invoice' => $invoice, 'stocksModel' => $stocksModel]);
    }

    public function updateInvoice(Request $request, $id) {
        $invoice = Invoice::findOrFail($id);
        $updateData = $request->all();
        $updateData['profit'] = floatval( $request->net_amount - Purchase::findOrFail($request->item_id)->purchase_price );
        $updateData['invoice_by'] = auth()->user()->id;
        // dd($updateData);
        $invoice->update($updateData);
        return redirect()->route('allinvoices')->withStatus('Invoice Updated Successfully..');
    }

    public function amoutInWords(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',16 => 'Sixteen', 17 => 'Seventeen', 18 =>'Eighteen',19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
            $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');

            while( $x < $count_length ) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string [] = ($amount < 21) ? $change_words[$amount].' '.$here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount %10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                }
        else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . 'Only ' : '') . $get_paise;
    }
}
