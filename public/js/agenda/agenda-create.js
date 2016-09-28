$(document).ready(function(){
	//Autocomplete Client
	var client = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('client_name'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  initialize: false,
	  remote: {
	    url: base_url + 'master/client/apiSearch/%QUERY%',
	    wildcard: '%QUERY%'
	  }
	});

	$('#client').typeahead({
		/*hint: true,*/
		highlight: true,
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
				return '<a href="#" class="list-group-item">' + data.client_name + '</a>'
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
	});

	//Autocomplete Client Contact
	var clientcontact = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('client_contact_name'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  initialize: false,
	  remote: {
	    url: base_url + 'master/clientcontact/apiSearch/%QUERY%',
	    wildcard: '%QUERY%'
	  }
	});

	$('#clientcontact').typeahead({
		/*hint: true,*/
		highlight: true,
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
				return '<a href="#" class="list-group-item">' + data.client_contact_name + ' - ' + data.client_name + '</a>'
			}
		}
	});

	$('#clientcontact').bind('typeahead:select', function(ev, suggestion) {
		$('#list-clientcontact-id').append('<input type="hidden" name="client_contact_id[]" id="clientcontact-id-' + suggestion.client_contact_id + '" value="' + suggestion.client_contact_id + '"><span id="span-clientcontact-id-' + suggestion.client_contact_id + '" class="badge">' + suggestion.client_contact_name + ' - ' + suggestion.client_name + '&nbsp;<a href="javascript:void(0)" style="color:#fff;" class="delete-clientcontact-id" data-clientcontactid="' + suggestion.client_contact_id + '"> x </a></span>&nbsp;&nbsp;');

		$('#clientcontact').val('');
	});

	$('body').on('click', '.delete-clientcontact-id-id',  function() {
		var ccid = $(this).data('clientcontactid');

		$('#clientcontact-id-' + ccid).remove();
		$('#span-clientcontact-id-id-' + ccid).remove();
	});
});