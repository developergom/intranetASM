$(document).ready(function(){
	//Autocomplete Client
	/*var client = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('client_name'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  initialize: false,
	  remote: {
	    url: base_url + 'master/client/apiSearch/%QUERY%',
	    wildcard: '%QUERY%'
	  }
	});

	$('#client').typeahead({*/
		/*hint: true,*/
	/*	highlight: true,
		minLength: 3,
		}, 
		{
		display: function(data) {
					return data.client_name
				},
		source: client.ttAdapter(),
		name: 'clients',
		limit: 5,
		templates: {
			empty: [
				'<div class="list-group search-results-dropdown"><a class="list-group-item">Nothing found.</a></div>'
			],
			header: [
				'<a class="list-group-item">Clients</a>'
			],
			suggestion: function(data) {
				return '<a href="javascript:void(0)" class="list-group-item">' + data.client_name + '</a>'
			}
		}
	});

	$('#client').bind('typeahead:select', function(ev, suggestion) {
		$('#list-client-id').append('<input type="hidden" name="client_id[]" id="client-id-' + suggestion.client_id + '" value="' + suggestion.client_id + '"><span id="span-client-id-' + suggestion.client_id + '" class="badge">' + suggestion.client_name + '&nbsp;<a href="javascript:void(0)" style="color:#fff;" class="delete-client-id" data-clientid="' + suggestion.client_id + '"> x </a></span>&nbsp;&nbsp;');

		$('#client').val('');
	});

	$('body').on('click', '.delete-client-id',  function() {
		var cid = $(this).data('clientid');

		$('#client-id-' + cid).remove();
		$('#span-client-id-' + cid).remove();
	});*/

	//Autocomplete Client Contact
	/*var clientcontact = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('client_contact_name'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  initialize: false,
	  remote: {
	    url: base_url + 'master/clientcontact/apiSearch/%QUERY%',
	    wildcard: '%QUERY%'
	  }
	});*/

	/*$('#clientcontact').typeahead({*/
		/*hint: true,*/
	/*	highlight: true,
		minLength: 3,
		}, 
		{
		display: function(data) {
					return data.client_contact_name + ' - ' + data.client_name
				},
		source: clientcontact.ttAdapter(),
		name: 'clientcontacts',
		limit: 5,
		templates: {
			empty: [
				'<div class="list-group search-results-dropdown"><a class="list-group-item">Nothing found.</a></div>'
			],
			header: [
				'<a class="list-group-item">Contacts</a>'
			],
			suggestion: function(data) {
				return '<a href="javascript:void(0)" class="list-group-item">' + data.client_contact_name + ' - ' + data.client_name + '</a>'
			}
		}
	});*/

	/*$('#clientcontact').bind('typeahead:select', function(ev, suggestion) {
		$('#list-clientcontact-id').append('<input type="hidden" name="client_contact_id[]" id="clientcontact-id-' + suggestion.client_contact_id + '" value="' + suggestion.client_contact_id + '"><span id="span-clientcontact-id-' + suggestion.client_contact_id + '" class="badge">' + suggestion.client_contact_name + ' - ' + suggestion.client_name + '&nbsp;<a href="javascript:void(0)" style="color:#fff;" class="delete-clientcontact-id" data-clientcontactid="' + suggestion.client_contact_id + '"> x </a></span>&nbsp;&nbsp;');

		$('#clientcontact').val('');
	});

	$('body').on('click', '.delete-clientcontact-id',  function() {
		var ccid = $(this).data('clientcontactid');

		$('#clientcontact-id-' + ccid).remove();
		$('#span-clientcontact-id-' + ccid).remove();
	});*/

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

    $('#proposal_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/workorder/proposal/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    proposal_name: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var proposals = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                proposals.push(
                    {
                        'value': curr.proposal_id,
                        'text': curr.proposal_name,
                        'disabled': false
                    }
                );
            }            
            return proposals;
        },
        preserveSelected: true
    });
});