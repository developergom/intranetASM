$(document).ready(function(){
    $('#result_target_amount').append(previewMoney($('#target_amount').val()));

	//target amount number format
	$('#target_amount').keyup(function() {
		$('#result_target_amount').empty();
		var res = previewMoney($(this).val());
		$('#result_target_amount').append(res);
	});

	$('#target_year, #target_month, #media_id, #industry_id').change(function(){
		var media_id = $('#media_id').val();
		var industry_id = $('#industry_id').val();
		var target_month = $('#target_month').val();
		var target_year = $('#target_year').val();

		$.ajax({
			url : base_url + 'master/target/api/generateCode',
			type: 'POST',
            data: {
                'media_id' : media_id,
                'industry_id' : industry_id,
                'target_month' : target_month,
                'target_year' : target_year,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function(data) {
                $('#target_code').val('');
                swal({
                  title: "ERROR",
                  text: "Generating code error!",
                  type: "warning"
                });
            },
            success: function(data) {
                $('#target_code').val(data.code);
            }
		});
	});	
});