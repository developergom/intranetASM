$(document).ready(function(){
	var myToken = $('meta[name="csrf-token"]').attr('content');

	$('#client_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + 'master/client/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    clientName: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var clients = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                clients.push(
                    {
                        'value': curr.client_id,
                        'text': curr.client_name,
                        'disabled': false
                    }
                );
            }            
            return clients;
        },
        preserveSelected: true
    });

    $('#rate_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + 'master/rate/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    rate_name: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var rates = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                rates.push(
                    {
                        'value': curr.rate_id,
                        'text': curr.rate_name,
                        'disabled': false
                    }
                );
            }            
            return rates;
        },
        preserveSelected: true
    })
    .on('hidden.bs.select', function(e) {
    	var rate_id = $(this).val();

    	$.ajax({
    		url: base_url + 'master/rate/apiSearchPerID',
    		dataType: 'json',
    		type: 'POST',
    		data: { 
    				_token: myToken,
                    rate_id: rate_id },
            error: function(data) {
            	console.log('error loading rate');
            },
            success: function(data) {
            	var base_rate = data.gross_rate;
            	var gross_rate = base_rate * parseInt($('#summary_item_insertion').val());
            	$('#media_name').val(data.media_name);
            	$('#base_rate').val(base_rate);
            	$('#summary_item_gross').val(gross_rate);
            	$('#format_summary_item_gross').empty().append(previewMoney(gross_rate));
            }
    	});
    });

    $('#summary_item_insertion').change(function(){
    	var gross_rate = parseInt($('#base_rate').val()) * parseInt($('#summary_item_insertion').val());
    	$('#summary_item_gross').val(gross_rate);
        $('#format_summary_item_gross').empty().append(previewMoney(gross_rate));
    });

    $('#summary_item_gross').keyup(function(){
    	$('#format_summary_item_gross').empty().append(previewMoney($(this).val()));
    });

    $('#summary_item_nett').keyup(function(){
    	calculate($(this).val());
    });

    $('#btn-recalculate').click(function(){
    	calculate($('#summary_item_nett').val());
    });
});

function calculate(nett)
{
	$('#format_summary_item_nett').empty().append(previewMoney(nett));
	$('#format_summary_item_po').empty().append(previewMoney(nett));
	$('#format_summary_item_internal_omzet').empty().append(previewMoney(nett));
	$('#summary_item_po').val(nett);
	$('#summary_item_internal_omzet').val(nett);

	//calculate disc
	gross = parseInt($('#summary_item_gross').val());
	discount = (gross - parseInt(nett));
	disc = Math.floor((discount/gross) * 100);

	$('#summary_item_disc').val(disc);

	ppn = Math.floor(0.1 * parseInt(nett));
	total = Math.floor(1.1 * parseInt(nett));

	$('#summary_item_ppn').val(ppn);
	$('#summary_item_total').val(total);
	$('#format_summary_item_ppn').empty().append(previewMoney(ppn));
	$('#format_summary_item_total').empty().append(previewMoney(total));
}