$(document).ready(function(){

    alertify.set('notifier', 'position', 'top-right');
   
    $(document).on('click', '.increment', function(){

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();        
        var currentValue = parseInt($quantityInput.val());
        
        if(!isNaN(currentValue)){
            var qtyVal = currentValue + 1; 
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal)
        }
    });

    $(document).on('click', '.decrement', function(){

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();        
        var currentValue = parseInt($quantityInput.val());
        
        if(!isNaN(currentValue) && currentValue > 1){
            var qtyVal = currentValue - 1; 
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal)
        }
    });

    function quantityIncDec(prodId, qty){
        $.ajax({
            type: 'POST',
            url: 'orders-code.php',
            data: {
                'productIncDec' : true,
                'product_id' : prodId,
                'quantity' : qty 
            },
            success: function(response){
                var res = JSON.parse(response);

                if(res.status == 200){
                    $('#productArea').load(' #productContent');
                    alertify.success(res.message);
                }else{
                    $('#productArea').load(' #productContent');
                    alertify.error(res.message);
                }
            }
        });
    }

    //proceed to place button
    $(document).on('click', '.proceedToPlace', function () {

        console.log('proceed to place button clicked');

        var cphone = $('#cphone').val();
        var payment_mode = $('#payment_mode').val();

        if(payment_mode == ''){
            swal("Select Payment Mode","Select your payment mode","warning");
            return false;
        }
        if(cphone == '' && !$.isNumeric(cphone)){
            swal("Enter Customer Phone","Enter valid customer phone","warning");
            return false;
        }

        var data = {
            proceedToPlaceBtn : true,
            'cphone' : cphone,
            'payment_mode' : payment_mode, 
        }

        $.ajax({
            type: 'POST',
            url: 'orders-code.php',
            data: data,
            success: function(response){
                var res = JSON.parse(response);

                if(res.status == 200){
                    window.location.href = 'order-summary.php';

                }else if(res.status == 404){
                    swal(res.message, res.message, res.status_type, {
                        buttons : {
                            catch: {
                                text: "Add Customer",
                                value: "catch",
                            },
                            cancel: "Cancel"
                        }
                    })
                    .then((value) => {
                        switch(value){
                            case "catch":
                                $('#c_phone').val(cphone);
                                $('#addCustomerModal').modal('show');
                                //console.log("catch button clicked");
                                break;
                            default:
                        }
                    });
                }else{
                    swal(res.message, res.message, res.status_type);
                }
            }
        });


    });

    // Add customer
    $(document).on('click', '.saveCustomer', function () {

        var c_name = $('#c_name').val().trim();
        var c_email = $('#c_email').val().trim();
        var c_phone = $('#c_phone').val().trim();

        // Validate required fields
        if (c_name === '' || c_phone === '') {
            swal("Please fill required fields", "", "warning");
            return;
        }

        // Validate phone number (only numbers)
        if (!$.isNumeric(c_phone)) {
            swal("Enter valid phone number", "", "warning");
            return;
        }

        var data = {
            'saveCustomer': true,
            'name': c_name,
            'email': c_email,
            'phone': c_phone,
        };

        $.ajax({
            type: 'POST',
            url: 'orders-code.php',
            data: data,
            success: function (response) {

                var res = JSON.parse(response);

                if (res.status == 200) {
                    swal(res.message, res.message, res.status_type);
                    $('#addCustomerModal').modal('hide');                
                }
                else if(res.status == 422){
                    swal(res.message, res.message, res.status_type);
                } 
                else {
                    swal(res.message, res.message, res.status_type);
                }
            },
            error: function () {
                swal("Something went wrong!", "", "error");
            }
        });

    });

    // Save order
    $(document).on('click', '#saveOder', function () {

        $.ajax({
            type: 'POST',
            url: 'orders-code.php',
            data: {
                'saveOrder': true,
            },
            success: function (response) {

                var res = JSON.parse(response);

                if (res.status == 200) {
                    swal(res.message, res.message, res.status_type);  
                    $('#orderPlaceSuccessMessage').text(res.message);
                    $('#orderSuccessModel').modal('show');             
                } 
                else {
                    swal(res.message, res.message, res.status_type);
                }
            }
        });

    });
   
});

// Print billing area
    function printMyBillingArea() {
        var divContents = document.getElementById("myBillingArea").innerHTML;
        var a = window.open('', '');
        a.document.write('<html><title>POS System in PHP</title>');
        a.document.write('<body style="font-family: fangsong;">');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }

window.jsPDF = window.jspdf.jsPDF;
var docPDF = new jsPDF();

function downloadPDF(invoiceNo){
    
    var elementHTML = document.querySelector("#myBillingArea");
    docPDF.html(elementHTML, {
        callback: function(){
            docPDF.save(invoiceNo + ".pdf");
        },
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650,
    });

}