$(document).ready(function(){
	var myToken = $('meta[name="csrf-token"]').attr('content');
	var default_proposal_type_id = $('#proposal_type_id').val();

	$.ajax({
		url: base_url + 'workorder/proposal/api/generateDeadline',
		dataType: 'text',
		type: 'POST',
		data: { 
				_token: myToken,
                proposal_type_id: default_proposal_type_id },
        error: function(data) {
        	console.log('error generate deadline');
        },
        success: function(data) {
        	$('#proposal_deadline').val(data);
        }
	});

	//budget number format
	$('#proposal_budget').keyup(function() {
		$('#result_proposal_budget').empty();
		var res = previewMoney($(this).val());
		$('#result_proposal_budget').append(res);
	});

	//bootstrap select
	$('#client_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/master/client/apiSearch',
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
        	/*console.log(data);*/
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
    })
    .on('hidden.bs.select', function(e) {
    	var client_id = $(this).val();

    	$.ajax({
    		url: base_url + 'master/clientcontact/apiSearchPerClient',
    		dataType: 'json',
    		type: 'POST',
    		data: { 
    				_token: myToken,
                    client_id: client_id },
            error: function(data) {
            	console.log('error loading contacts');
            },
            success: function(data) {
            	var dr = '';
            	$('#client_contact_id').empty();
            	$.each(data, function(key, value) {
            		dr += '<option value="' + value.client_contact_id + '">' + value.client_contact_name + ' - ' + value.client_contact_position + '</option>';
            	});
            	$('#client_contact_id').append(dr);

            	$('#client_contact_id').selectpicker('refresh');
            }
    	});
    });

    $('#inventory_planner_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/inventory/inventoryplanner/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    inventory_planner_title: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
        	/*console.log(data);*/
            var inventories = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                inventories.push(
                    {
                        'value': curr.inventory_planner_id,
                        'text': curr.inventory_planner_title,
                        'disabled': false
                    }
                );
            }            
            return inventories;
        },
        preserveSelected: true
    });

    $('#brand_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/master/brand/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    brand_name: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
        	/*console.log(data);*/
            var brands = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                brands.push(
                    {
                        'value': curr.brand_id,
                        'text': curr.brand_name,
                        'disabled': false
                    }
                );
            }            
            return brands;
        },
        preserveSelected: true
    });

    //proposal types
    $('#proposal_type_id').change(function(){
    	var proposal_type_id = $(this).val();

    	$.ajax({
    		url: base_url + 'workorder/proposal/api/generateDeadline',
    		dataType: 'text',
    		type: 'POST',
    		data: { 
    				_token: myToken,
                    proposal_type_id: proposal_type_id },
            error: function(data) {
            	console.log('error generate deadline');
            },
            success: function(data) {
            	$('#proposal_deadline').val(data);
            }
    	});
    });
});