@extends('layout.app')

@section('title')
    Sales Charts Report
@endsection
@section('content')
@php
    $currentMonth = \Carbon\Carbon::now()->format('F');
@endphp
<script src="https://cdn.plot.ly/plotly-2.26.1.min.js"></script>
<div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Sales Analytics for [{{$currentMonth}}]</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-sm-12 col-md-6">
            <div id="dailySales" class="chart"></div>
        </div>
        <div class="col-6 col-sm-12 col-md-6">
            <div id="paymentMode" class="chart"></div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-sm-12 col-md-12">
            <div id="profitAnalysis" class="chart"></div>
            <script>
                const config = {
                    displayModeBar: false // Disable the modebar
                };
                const groupBy = (array, key) =>
                    array.reduce((result, item) => {
                      (result[item[key]] = result[item[key]] || []).push(item);
                      return result;
                    }, {});

                 const sumBy = (array, key) =>
                    array.reduce((total, item) => total + item[key], 0);
                
                const salesData = {!! $allSales !!};

                // Daily Sales Overview
                const dailySalesData = groupBy(salesData, "invoice_date");
                const dailyDates = Object.keys(dailySalesData);
                const dailyRevenue = dailyDates.map(date => sumBy(dailySalesData[date], "net_amount"));

                Plotly.newPlot('dailySales', [{
                    x: dailyDates,
                    y: dailyRevenue,
                    type: 'bar',
                    marker: { color: 'blue' },
                }], {
                    title: 'Daily Sales Overview',
                    xaxis: { title: 'Date' },
                    yaxis: { title: 'Revenue (₹)' },
                });

                // Profit Analysis
                // console.log(salesData)
                const invoiceDates = salesData.map(sale => sale.invoice_date);
                const netAmounts = salesData.map(sale => sale.net_amount);

                const dailyProfitData = groupBy(salesData, "invoice_date");
                const dailyProfitDates = Object.keys(dailyProfitData);

                // const dailyRevenue = dailyProfitDates.map(date => sumBy(dailyProfitData[date], "net_amount"));
                const dailyProfit = dailyProfitDates.map(date => sumBy(dailyProfitData[date], "profit"));

                // Plotly.js Configuration
                const trace = {
                    x: dailyProfitDates,
                    y: dailyProfit,
                    type: 'line',
                    line: { shape: 'spline', color: 'green' },
                };

                const layout = {
                    title: 'Daily Profit Analysis',
                    xaxis: { title: 'Invoice Date' },
                    yaxis: { title: 'Profit (₹)' },
                    // margin: { t: 50, r: 20, b: 80, l: 50 },
                };

                // Generate the chart
                Plotly.newPlot('profitAnalysis', [trace], layout, config);

                const paymentData = groupBy(salesData, "payment_type");
                const paymentModes = Object.keys(paymentData);
                console.log(paymentData);
                const paymentCounts = paymentModes.map(mode => paymentData[mode].length);

                Plotly.newPlot('paymentMode', [{
                    labels: paymentModes,
                    values: paymentCounts,
                    type: 'pie',
                }], {
                    title: 'Payment Mode Breakdown',
                });
            </script>
        </div>
    </div>
</div>
@endsection