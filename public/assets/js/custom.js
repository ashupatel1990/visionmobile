jQuery(document).ready(function(){
    // fetch stock data on sale page
    jQuery("#salemodelimei").on('blur', function(e) {
        var modelID = jQuery("#salemodelimei").val();
        // console.log(modelID);
        if (modelID) {
            jQuery.ajax({
                url: '/admin/fetchstockdata/'+ modelID,
                type: 'GET',
                success: function (data) {
                    $(".defaulthide, .nodatahide").hide();
                    if (data.count > 0) {
                        $(".defaulthide").show();
                        $("#device_model").html(data.stock['model']);
                        $("#model_color").html(data.stock['color']);
                        $("#imei").html(data.stock['imei']);
                        $("#storage").html(data.stock['storage']);
                        $("#purchase_cost").html(data.stock['purchase_cost']);
                        $("#repairing_charge").html(data.stock['repairing_charge']);
                        $("#purchase_price").html(data.stock['purchase_price']);
                        $("#modelpurchaseprice").val(data.stock['purchase_price']);
                    } else {
                        $(".nodatahide").show();
                        $("#nodatafound").html('No Data Found!');
                    }
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            $(".defaulthide").hide();
        }
    });

    jQuery("#model_imei").on('blur', function(e) {
        var modelIMEI = jQuery("#model_imei").val();
        if (modelIMEI) {
            jQuery.ajax({
                url: '/admin/fetchstockonimei/'+ modelIMEI,
                type: 'GET',
                success: function (data) {
                    $("#model_imei").removeClass('parsley-error')
                    $("#item_description").html('');
                    if (data.count > 0) {
                        $("#parsley-id-imei").hide();
                        // Invoice form
                        var descriptionTxt = '';
                        descriptionTxt += "Model: " + data.purchase['model']+"\n";
                        if (data.purchase['color']) {
                            descriptionTxt += "Color: " + data.purchase['color']+"\n";
                        }
                        if (data.purchase['storage']) {
                            descriptionTxt += "Storage: " + data.purchase['storage']+"\n";
                        }
                        if (data.purchase['imei']) {
                            descriptionTxt += "IMEI: " + data.purchase['imei']+"\n";
                        }
                        $("#itemID").val(data.purchase['id']);
                        // descriptionTxt += "Model: " + data.model+"\n"+"Color: " + data.color+"\n"+"Storage: " + data.storage+"\n"+"IMEI: " + data.imei;
                        $("#item_description").html(descriptionTxt);
                        $("#quantity").val(data.count);
                    } else {
                        $("#parsley-id-imei").show();
                        $("#parsley-id-imei").focus();
                        $("#model_imei").addClass('parsley-error');
                    }
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            $(".defaulthide").hide();
        }
    });

    jQuery("#findbystatus, #selectperiod").on('change', function(e) {
        if(jQuery(this).val() == 'custom') {
            $("#fromdate, #todate").show();
        } else {
            $("#fromdate, #todate").hide();
            $("#dashboardfilter").submit();
        }
    });

    jQuery("#findbysold, #selectyear, #selectstorage, #sortby, #selectcolor").on('change', function(e) {
        jQuery("#filterpurchase").submit();
    });

    jQuery("#sortbyno").on('click', function(e) {
        jQuery("#filterpurchase").submit();
    });

    /* filter on sales records*/
    jQuery("#selectyear, #selestorage, #payments, #searchsales").on('change', function(e) {
        jQuery("#filtersales").submit();
    });

    jQuery("#selectsalesperiod").on('change', function(e) {
        if(jQuery(this).val() == 'custom') {
            $("#salefromdate, #saletodate").show();
        } else {
            $("#salefromdate, #saletodate").hide();
            jQuery("#salesreport").submit();
        }
    });
    jQuery("#selectyear, #selectmonth").on('change', function(e) {
        jQuery("#filterexpense").submit();
    });
    $("#salesdownloadperiod").on('change', function(e) {
        if(jQuery(this).val() == 'custom') {
            $("#fromdate, #todate").show();
        } else {
            $("#fromdate, #todate").hide();
        }
    })
    // $("#saleprice").blur(function(){
    //     var saleprice = $(this).val();
    //     var purchaseprice = parseFloat($("#purchase_price").html());
    //     if(saleprice <= purchaseprice) {
    //         alert('Sale Price should be greater than Purchase Price');
    //         $(this).val(0);
    //     }
    // });
    const today = new Date().toISOString().split('T')[0];
    jQuery("#warrentydate").attr('min', today);
    jQuery("#warrenty").change(function(e) {
        if ( $(".warrenty_date").is(':visible')) {
            $(".warrenty_date").hide();
        } else {
            $(this).hide();
            $(".warrenty_date").show();
        }
    });
});

function sureToDelete(e) {
    if(confirm('Are You sure you want to delete this?')){
        return true;
    }else{
        e.preventDefault();
    }
}
function calculateNetAmount() {
    totalAmount = 0;
    var totalAmount = parseFloat(
      document.getElementById("totalAmountInput").value
    );
    if (isNaN(totalAmount)) {
        totalAmount = 0;
    }
    
    var cgst = parseFloat(document.getElementById("cgst").value) || 0;
    var sgst = parseFloat(document.getElementById("sgst").value) || 0;
    var igst = parseFloat(document.getElementById("igst").value) || 0;

    // CGST SGST and IGST code
    var cgstAmt = (cgst / 100) * totalAmount;
    var sgstAmt = (sgst / 100) * totalAmount;
    var igstAmt = (igst / 100) * totalAmount;

    var totalTax = ((cgst + sgst + igst) / 100) * totalAmount;
    var netAmount = totalTax + totalAmount;

    // Adding calculated amounts on fields and display
    document.getElementById("totalAmountDisplay").innerText =
    totalAmount.toFixed(2);
    document.getElementById("taxDisplay").innerText = totalTax.toFixed(2);
    document.getElementById("taxAmount").value = totalTax.toFixed(2);

    // discountRate = parseFloat(document.getElementById("discount").value) || 0;
    // var discountAmt = (discountRate / 100) * totalAmount;
    var discountAmt = parseFloat(document.getElementById('discAmount').value) || 0; // = discountAmt.toFixed(2);
    console.log(discountAmt)
    document.getElementById('discountAmount').innerText = discountAmt.toFixed(2);
    // document.getElementById('discountDisplay').innerText = discountAmt.toFixed(2);
    netAmount = netAmount - discountAmt;

    document.getElementById("netAmountDisplay").innerText = netAmount.toFixed(2);
    document.getElementById("netAmount").value = netAmount.toFixed(2);

    document.getElementById("cgstDisplay").innerText = cgstAmt.toFixed(2);
    document.getElementById("cgstAmount").value = cgstAmt.toFixed(2);

    document.getElementById("sgstDisplay").innerText = sgstAmt.toFixed(2);
    document.getElementById("sgstAmount").value = sgstAmt.toFixed(2);

    document.getElementById("igstDisplay").innerText = igstAmt.toFixed(2);
    document.getElementById("igstAmount").value = igstAmt.toFixed(2);
    console.log(totalAmount)

}

function calculateTotalAmount() {
    var oneAmount = parseFloat(document.getElementById("totalInput").value);
  
    console.log(oneAmount);
    if (isNaN(oneAmount)) {
      oneAmount = 0;
    }
    document.getElementById("totalDisplay").innerText = oneAmount.toFixed(2);
  }