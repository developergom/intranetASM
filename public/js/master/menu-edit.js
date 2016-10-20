$(document).ready(function(){
	$('#menu_parent').change(function(){
		var parent_id = $(this).val();
		
		$.ajax({
			url: base_url + 'master/menu/apiCountChild',
			type: 'POST',
			data: { 
					'parent_id' : parent_id,
					'_token' : $('meta[name="csrf-token"]').attr('content')
					},
			dataType: 'json',
			error: function(data){
				$('#menu_order').empty();
				swal({
		          title: "ERROR",
		          text: "Fetching data error!",
		          type: "warning"
		        })
			},
			success: function(data){
				var max = data.count + 1;

				$('#menu_order').empty();
				for(i = 1; i <= max; i++)
				{
					$('#menu_order').append('<option value="' + i + '">' + i + '</option>');
				}

				$('#menu_order').selectpicker('refresh');
			}
		});
	});
});