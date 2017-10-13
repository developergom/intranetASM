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
            	$('#media_name').val(data.media_name);
            	$('#summary_item_gross').val(data.gross_rate);
            	$('#format_summary_item_gross').empty().append(previewMoney(data.gross_rate));
            }
    	});
    });

    $('#summary_item_gross').keyup(function(){
    	$('#format_summary_item_gross').empty().append(previewMoney($(this).val()));
    })
});