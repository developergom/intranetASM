var myToken = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function() {
	reset_columns();
	show_columns($('#advertise_rate_type_id').val());

	$('#advertise_rate_type_id').change(function() {
		var advertise_rate_type_id = $(this).val();
		
		reset_columns();
		show_columns(advertise_rate_type_id);
		
	});
});

function reset_columns()
{
	$('#media_id_container').hide();
	$('#rate_name_container').hide();
	$('#width_container').hide();
	$('#length_container').hide();
	$('#unit_id_container').hide();
	$('#studio_id_container').hide();
	$('#duration_container').hide();
	$('#duration_type_container').hide();
	$('#spot_type_container').hide();
	$('#gross_rate_container').hide();
	$('#discount_container').hide();
	$('#nett_rate_container').hide();
	$('#start_valid_date_container').hide();
	$('#end_valid_date_container').hide();
	$('#cinema_tax_container').hide();
	$('#paper_id_container').hide();
	$('#color_id_container').hide();
}

function show_columns(advertise_rate_type_id)
{
	if(advertise_rate_type_id!='') {
		$.ajax({
			url: base_url + "/master/advertiseratetype/api/getRequiredFields",
			type: "POST",
			dataType: "json",
			data: {
				'advertise_rate_type_id' : advertise_rate_type_id,
				_token: myToken
			},
			success: function(data) {
				$.each(data, function(key, value) {
					$('#' + value + '_container').show();
				});
			}
		});
	}
}