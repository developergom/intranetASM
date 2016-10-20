$(document).ready(function(){
	$('#advertise_rate_normal_tmp,#advertise_rate_discount_tmp').keydown(function(e){
		validateNumberOnly(e);
		clearNumberSeparator();
	});

	$('#advertise_rate_normal_tmp,#advertise_rate_discount_tmp').priceFormat({
	    prefix: '',
	    centsLimit: 0,
	    centsSeparator: ',',
	    thousandsSeparator: '.'
	});
});


function validateNumberOnly(e){
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
}

function clearNumberSeparator(){
	var rate_normal = $('#advertise_rate_normal_tmp').val();
	var rate_discount = $('#advertise_rate_discount_tmp').val();

	rate_normal = rate_normal.replace(/[^\/\d]/g,'');
	rate_discount = rate_discount.replace(/[^\/\d]/g,'');

	$('input[name="advertise_rate_normal"]').val(rate_normal);
	$('input[name="advertise_rate_discount"]').val(rate_discount);
}