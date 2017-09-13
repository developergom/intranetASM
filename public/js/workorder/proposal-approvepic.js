$(document).ready(function() {
	var myToken = $('meta[name="csrf-token"]').attr('content');
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