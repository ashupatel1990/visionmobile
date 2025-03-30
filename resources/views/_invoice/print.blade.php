@extends('layout.app')

@section('title')
    Invoice #{{$invoice->invoice_no}}
@endsection
@section('content')
<style>


ol {
    padding-left: 15px;
}
ol li {
    font-size: 11px;
    font-weight: 600;
    line-height: 17px;
}
table.bill-table tr table td { padding-left:5px; }
table.bill-table tr.billed-to td { padding-left:5px; color: #000; }
.item_details thead th { text-align: center; }
.tax_details h5 { margin: 0px 0; }
.blueheader { background-color: #0986c6a3; border-bottom: 1px solid #000; }
.terms { color: #ed1547;  }
.conditions { color: #0986c6a3; }
.fs15 { font-size: 15px; }
.fs16 { font-size: 16px; }
tr td ul {
    padding-bottom: 50px;
    padding-left: 15px;
}
tr td ul li {
    font-size: 11px;
    font-weight: 800;
    padding-bottom: 4px;
}
td { color: #000; font-size:15px; }
.footer-text { color: #000; text-align: right; padding-right: 30px; -webkit-print-color-adjust: exact; color-adjust: exact; }
@media print {
    @page {
        margin: 0; /* Remove default margins to make more space */
    }
    table.bill-table tr table td { padding-left:5px; }
    table.bill-table tr.billed-to td { padding-left:5px; color: #000; }
    .item_details thead th { text-align: center; }
    .tax_details h5 { margin: 0px 0; }
    /* .bill-table { border: 1px solid; } */
    .terms { color: #ed1547; -webkit-print-color-adjust: exact; color-adjust: exact; }
    .conditions { color: #0382cd; -webkit-print-color-adjust: exact; color-adjust: exact; }
    .blueheader { 
        background-color: #0986c6a3; 
        border-bottom: 1px solid #000; 
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    ul {
        padding-left: 15px;
        -webkit-print-color-adjust: exact;
        padding-bottom: 50px;
    }
    ul li {
        font-size: 11px;
        font-weight: 600;
        line-height: 17px;
        font-weight: 800;
        padding-bottom: 4px;
    }
    .fs15 { font-size: 15px; }
    .fs16 { font-size: 16px; }
    .footer-text { color: #000; text-align: right; padding-right: 30px; -webkit-print-color-adjust: exact; color-adjust: exact; }
    table tr td { color: #000; font-size:15px; }
}
</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Invoice: #{{ $invoice->invoice_no }}</h4>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="card-box">
                <!-- Company Info -->
                 <h2 style="text-align: center;">RECEIPT</h2>
                <div class="clearfix">
                    <table style="width:100%; margin-top: 50px;" border="1" class="bill-table">
                        <tr>
                            <td style="width:50%">
                                <table>
                                    <tr>
                                        <td><img src="{{asset('assets/images/visionlogo-wb.png')}}" width="130"></td>
                                        <td style="padding-left: 50px;"><h3>Vision Mobile</h3><span>Shop No.112, 1st Floor, Shivalik Platinum, <br/> Opp. Chief Justice Bunglow, <br/>Bodakdev, Ahmedabad - 380054</span><br><span><b>Mo:</b>+91 89898 09797, +91 89899 05757</span></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:50%;border: 1px solid;" colspan="4">
                                <table style="width:100%; border-bottom: 1px solid;">
                                    <tr style=" border-bottom: 1px solid;" class="blueheader">
                                        <td colspan="2" align="center" style="padding: 5px 0; font-size: 16px;"><b style="color:#000">Invoice Detail</b></td>
                                    </tr>
                                    <!-- <tr><td colspan="2" style="line-height: 5px;">&nbsp;</td></tr> -->
                                    <tr>
                                        <td style="width:50%; padding: 10px 5px; border-right:1px solid; line-height: 35px;"><b style="color:#000">Invoice/Bill No.: </b>#{{ $invoice->invoice_no }}</td>
                                        <td><b style="color:#000">Date:</b> {{ date("d/m/Y", strtotime($invoice->invoice_date)) }}</td>
                                    </tr>
                                    <!-- <tr><td style="line-height: 5px;">&nbsp;</td></tr> -->
                                </table>
                                <table style="width:100%;">
                                    <tbody>
                                    <tr>
                                        <td style="width:50%;  border-right:1px solid; line-height: 40px; padding: 5px;"><b style="color:#000">Payment Type: </b> {{ $invoice->payment_type }}</td>
                                        <td>
                                            @if($invoice->warranty_expiry_date != null)
                                            <b style="color:#000">Warrenty Expiry: </b> {{ date("d/m/Y", strtotime($invoice->warranty_expiry_date)) }}
                                            @else
                                                &nbsp;
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="billed-to">
                            <td colspan="5" class="mb-2 fs15" style="padding: 10px;">
                                <h5>BILL TO:</h5>
                                <span><b style="color:#000">Name: &nbsp; </b> {{$invoice->customer_name}}</span><br/>
                                <span><b style="color:#000; ">Mobile:</b>&nbsp;{{$invoice->customer_no}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table style="width:100%;" class="item_details">
                                    <thead class="blueheader">
                                        <tr>
                                            <th align="center" style="width:10%; color:#000; background-color: #0986c64a; border-right: 1px solid; text-align:left; padding-left: 5px;">#</th>
                                            <th align="center" style="width:60%; color:#000; background-color: #0986c64a; border-right: 1px solid; padding-top: 10px; padding-bottom: 10px;">ITEMS</th>
                                            <th align="center" style="width:10%; color:#000; background-color: #0986c64a; border-right: 1px solid;">QTY.</th>
                                            <th align="center" style="width:10%; color:#000; background-color: #0986c64a; border-right: 1px solid;">RATE</th>
                                            <th align="center" style="width:15%; color:#000; background-color: #0986c64a;">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:10%; color:#000; border-right: 1px solid;">1</td>
                                            <td style="width:60%; color:#000; border-right: 1px solid; padding: 10px">@php echo nl2br($invoice->item_description) @endphp</td>
                                            <td style="width:10%; color:#000; border-right: 1px solid; text-align:center;">1</td>
                                            <td style="width:10%; color:#000; border-right: 1px solid;text-align:right; padding-right:20px;">₹{{$invoice->total_amount}}</td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;">₹{{$invoice->total_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table style="width:100%;" class="tax_details" border="0">
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #000;">
                                            <td colspan="4" align="right"><h4>Total:</h4></td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;"><b>₹{{ $invoice->total_amount }}</b></td>
                                        </tr>
                                        @if($invoice->cgst_rate)
                                        <tr>
                                            <td colspan="4" align="right"><b>CGST @if($invoice->cgst_rate) @ {{$invoice->cgst_rate}}% @endif :</td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;"><b>₹{{ $invoice->cgst_amount }}</b></td>
                                        </tr>
                                        @endif
                                        @if($invoice->sgst_rate)
                                        <tr>
                                            <td colspan="4" align="right"><b>CGST @if($invoice->sgst_rate) @ {{$invoice->sgst_rate}}% @endif :</td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;"><b>₹{{ $invoice->sgst_amount }}</b></td>
                                        </tr>
                                        @endif
                                        @if($invoice->igst_rate)
                                        <tr>
                                            <td colspan="4" align="right"><b>CGST @if($invoice->igst_rate) @ {{$invoice->igst_rate}}% @endif :</td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;"><b>₹{{ $invoice->igst_amount }}</b></td>
                                        </tr>
                                        @endif
                                        @if($invoice->discount)
                                        <tr>
                                            <td colspan="4" align="right"><b>Discount @if($invoice->discount_rate) @ {{$invoice->discount_rate}}% @endif :</td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px;"><b>- ₹{{ $invoice->discount }}</b></td>
                                        </tr>
                                        @endif
                                        @if($invoice->net_amount)
                                        <tr>
                                            <td colspan="4" align="right"><h4>Net Total:</h4></td>
                                            <td style="width:15%; color:#000; text-align:right; padding-right:10px; border-top: 1px solid;"><h4 style="color:#000">₹{{ $invoice->net_amount }}</h4></td>
                                        </tr>
                                        @endif
                                       
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="background-color:#0986c6a3; color: #000" class="blueheader">
                            <td colspan="4" style="padding-left:10px;" class="fs16">
                                <b>Amount (in words): </b> {{ $amountInWords }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding-left: 20px; padding-top: 50px;">
                                <h4><span class="terms">Terms</span> & <span class="conditions">Conditions</span></h4>
                                <ul>
                                    <li>પાણીથી /ભાંગ તૂટથી/ ઇલેક્ટ્રીક શોર્ટ સર્કિટથી થયેલી નુકસાની ની વોરંટી મળશે નહીં.</li>
                                    <li>કંપની વોરંટી દરમિયાન ગ્રાહકે જાતે જ કંપનીના સર્વિસ સેન્ટરમાં જવાનું રહેશે અને કંપનીનો નિર્ણય જ માન્ય ગણાશે.</li>
                                    <li>અમારી શોપ વોરંટી Expiry Date સુધી ગણાશે.</li>
                                    <li>અમારી વોરંટી દરમિયાન ફોનમાં કોઈ ખામી આવે તો તેની સર્વિસ થશે પાછું લેવા કે રિફંડ આપવામાં આવશે નહીં.</li>
                                    <li>ફોન લીધા બાદ જો રીટર્ન આપવું હશે કે એક્સચેન્જ કરવું હશે તો અમે આપેલા ભાવ જ માન્ય ગણાશે - ભાવ બાબતે કોઈ રક-જક કરવી નહીં.</li>
                                    <li>કોઈ પણ ફોન ની બેટરી (mAh) & ફોન ના વપરાશ ઉપર આધાર રાખે છે જેથી વોરંટી દરમિયાન ચેક કર્યા બાદ જો કોઈ ખામી જણાય તો જ (સર્વિસ/ચેન્જ) કરી આપવામાં આવશે. </li>
                                    <li>ફોન લેવા કે વેચવા માટે અમે આપેલા ભાવ એક દિવસ જ માન્ય રહેશે. </li>
                                    <li>ઇન્ટરનેશનલ(ગ્લોબલ) નવા કે જુના ફોનમાં કંપનીના નિયમો બદલાતા રહેતા હોય છે જેથી જે તે સમયે કંપની વોરંટી દરમિયાન કંપનીનો નિયમ જ માન્ય રહેશે. </li>
                                    <li>ફોન લેતા સમયે ફોન પર રહેલા ડેન્ટ કે સ્ક્રેચ ચકાસીને લેવા પછીથી આ બાબતે અમારી કોઇ જવાબદારી રહેશે નહીં.</li>
                                    <li>ફોન લીધા બાદ 24 કલાકની અંદર કંપનીના સર્વિસ સેન્ટરમાં ચેક કરાવી લેવું (જેમકે રીપેર થયેલ છે કે નહીં પાર્ટ્સ ચેન્જ છે કે નહીં બહાર ઓપન કરાવેલ છે કે નહીં વગેરે) પછીથી આ બાબતે અમારી કોઇ જવાબદારી રહેશે નહીં.</li>
                                    <li>રિપ્લેસમેન્ટ વખતે જે મોડલ ખરીદેલ હશે સામે બીજું સેમ મોડેલ જ મળશે.</li>
                                    <li>Display માં લાઈન-ડોટ-કલર ચેન્જ કે બીજી અન્ય તકલીફ માં વોરંટી મળશે નહીં.</li>
                                    <li>Android ઇન્ટરનેશનલ ફોનમાં 5G નેટવર્ક બેન્ડ અલગ આવતા હોવાથી 5G ચાલવા કે ના ચાલવાની જવાબદારી મળતી નથી.</li>
                                </ul>
                                <p class="footer-text">
                                    Authorised Signatory For<br><b>VISION MOBILE</b>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <!-- <div class="text-center">
                        <h1>Vision Mobile</h1>
                    </div>
                    <div class="text-center">
                        <span>Shop no.31, 1st floor, <br/>Rudra square, Opp.kalupur co.op.Bank, <br/>Judges Banglow cross Road,Bodakdev, Ahmedabad - 380054</span><br>
                        <span><b>Mo:</b>+91 89898 09797, +91 89899 05757</span>
                    </div> -->
                    <!-- <div class="row pb-1">
                        <div class="col-6 text-right">
                            <span class="text-right"><b>PAN NO:</b> TEST02984</span>
                        </div>
                        <div class="col-6">
                            <span>
                                <b>GSTIN NO:</b> TEST92895C0DE3</span>
                        </div>
                    </div> -->
                </div>
                <!-- end row -->
                <!-- <div class="row">
                    <div class="col-12 text-center border">
                        <b>
                            <h3 class="m-1">GST INVOICE </h3>
                        </b>
                    </div>
                </div> -->
                {{--
                    <div class="row text-center ">
                    <div class="col-md-6 border p-0">
                        <b>
                            <div class="border-bottom">
                                <h5>Billed To:</h5>
                            </div>
                        </b>
                        @if($invoice->customer_name)
                        <div class="row pl-2 pt-1">
                            <div class="col-12 d-flex justiy-content-start">
                                <!-- <label>Name:</label> -->
                                <span><b>{{$invoice->customer_name}} </b></span>
                            </div>
                        </div>
                        @endif
                        @if($invoice->customer_no)
                        <div class="row pl-2">
                            <div class="col-12 d-flex justiy-content-start">
                                <label>Mobile:</label>
                                <span class="ml-1"> {{$invoice->customer_no}} </span>
                            </div>
                        </div>
                        @endif
                        @if($invoice->customer_address)
                            <div class="row pl-2">
                                <div class="col-12 d-flex justiy-content-start">
                                    <label>Address:</label>
                                    <span class="ml-1"> {{ $invoice->customer_address}} </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 border p-0">
                        <b>
                            <div class="border-bottom">
                                <h5>Invoice Details</h5>
                            </div>
                        </b>
                        <div class="row pl-2 pt-1">
                            <div class="col-12 d-flex justiy-content-start">
                                <label><b>Invoice Number:</b></label>
                                <span class="ml-1">{{ $invoice->invoice_no }}</span>
                            </div>
                        </div>
                        <div class="row pl-2">
                            <div class="col-12 d-flex justiy-content-start">
                                <label><b>Invoice Date:</b></label>
                                <span class="ml-1">{{ date("d-m-Y", strtotime($invoice->invoice_date)) }}</span>
                            </div>
                        </div>
                        <div class="row pl-2">
                            <div class="col-12 d-flex justiy-content-start">
                                <label><b>Payment Type:</b></label>
                                <span class="ml-1">{{ $invoice->payment_type }}</span>
                            </div>
                        </div>
                    </div>
                    </div>
                --}}
                <!-- end row -->
            {{--
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="table-responsive table-bordered">
                            <table class="table mt-4 table-centered border">
                                <thead>
                                    <tr>
                                        <th class="py-0 text-center" style="width: 5%; background-color: rgb(130, 210, 241); color: black;">S.NO.</th>
                                        <th class="py-0 text-center" style="width: 62%; background-color: rgb(130, 210, 241); color: black;">ITEM DESCRIPTION</th>
                                        <th class="py-0 text-center" style="width: 8%; background-color: rgb(130, 210, 241); color: black;">QTY.</th>
                                        <th class="py-0 text-center" style="width: 10%; background-color: rgb(130, 210, 241); color: black;">RATE</th>
                                        <th style="width: 15%; background-color: rgb(130, 210, 241); color: black;" class="text-center py-1"> AMOUNT </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>@php echo nl2br($invoice->item_description) @endphp</td>
                                        <td class="text-right">1 Pcs.</td>
                                        <td class="text-right"> {{$invoice->total_amount}}</td>
                                        <td class="text-right"> {{$invoice->total_amount}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div> <!-- end col -->
                </div>
            --}}
            {{--    <div class="row border">
                    <div class="col-sm-6 col-lg-9 p-0">
                        <!-- <div class="clearfix pt-2 pb-2 mt-1 mb-1 ml-1 text-center" style="background-color: rgba(218, 218, 218, 0.37); border-radius: 5px;">
                            <h5><b>Bank Details</b></h5>
                            <p><b>bank_name  - ACCOUNT NO: account_no - IFSC: ifsc_code</b></p>
                        </div> -->
                        <div class="clearfix pt-2 pb-2 mt-1 mb-1 ml-1" style="background-color: rgba(218, 218, 218, 0.37); border-radius: 5px;">
                            <p><b>Amount in words:</b> {{ $amountInWords }} </p>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-sm-6 col-lg-3 mt-1">
                        <ul class="list-unstyled">
                            <li><b>Total :</b> <span class="float-right"><i class="fas fa-rupee-sign"></i> {{ $invoice->total_amount }}</span></li>
                            @if($invoice->cgst_amount)
                                <li><b>CGST @if($invoice->cgst_rate) @ {{$invoice->cgst_rate}}% @endif :</b><span class="float-right"><i class="fas fa-rupee-sign"></i> {{$invoice->cgst_amount }}</span></li>
                            @endif
                            @if($invoice->sgst_amount)
                                <li><b>SGST @if($invoice->sgst_rate) @ {{$invoice->sgst_rate}}% @endif :</b><span class="float-right"><i class="fas fa-rupee-sign"></i> {{ $invoice->sgst_amount }}</span></li>
                            @endif
                            @if($invoice->igst_amount)
                                <li><b>IGST @if($invoice->igst_rate) @ {{$invoice->igst_rate}}% @endif :</b><span class="float-right"><i class="fas fa-rupee-sign"></i> {{ $invoice->igst_amount }}</span></li>
                            @endif
                            @if($invoice->total_tax)
                                <li><b>Total Tax :</b><span class="float-right"><i class="fas fa-rupee-sign"></i> {{ $invoice->total_tax }}</span></li>
                            @endif
                            @if($invoice->discount_rate)
                                <li><b>Discount ({{ $invoice->discount_rate }}%) - :</b><span class="float-right"> <i class="fas fa-rupee-sign"></i> {{ $invoice->discount }}</span></li>
                            @endif
                            <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;"/>
                            <li><b>Net Amount :</b><span class="float-right"><h3><i class="fas fa-rupee-sign"></i> {{ $invoice->net_amount }}</h3></span></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div> <!-- end col -->
                </div>
            --}}

                <div class="mt-4 mb-1">
                    <div class="text-right d-print-none">
                        <a href="javascript:window.print()" title="#{{$invoice->invoice_no}}" class="btn btn-primary waves-effect waves-light">Print <i class="mdi mdi-printer mr-1"></i></a>
                        <a href="{{ route('allinvoices') }}" class="btn btn-danger waves-effect waves-light">All
                            Invoices <i class="fas fa-rupee-sign"></i></a>
                    </div>
                </div>
            </div> <!-- end card-box -->
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</div> 
@endsection