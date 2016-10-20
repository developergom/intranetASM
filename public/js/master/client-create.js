$(document).ready(function(){
    $('#copy_address').click(function(){
        var address = $('#client_mail_address').val();
        var postcode = $('#client_mail_postcode').val();

        $('#client_npwp_address').val(address);
        $('#client_npwp_postcode').val(postcode);

        $('#client_invoice_address').val(address);
        $('#client_invoice_postcode').val(postcode);
    });
});