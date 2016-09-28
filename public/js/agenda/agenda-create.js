$(document).ready(function(){
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
		/*console.log('Selection: ' + suggestion.client_name);
		$('#client_id').append('<option value="' + suggestion.client_id + '" selected>' + suggestion.client_name + '</option>');
		$('#client_id').selectpicker('refresh');*/

		$('#list-client-id').append('<input type="hidden" name="client_id[]" id="client-id-' + suggestion.client_id + '" value="' + suggestion.client_id + '"><span class="badge">' + suggestion.client_name + '&nbsp;<a href="javascript:void(0)" style="color:#fff;" class="delete-client-id" data-clientid="' + suggestion.client_id + '"> x </a></span>&nbsp;&nbsp;');

		$('#client').val('');
	});
});