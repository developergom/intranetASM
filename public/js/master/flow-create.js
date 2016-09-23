$(document).ready(function(){
	$('#flow_group_id').change(function(){
		var flow_group_id = $(this).val();
		
		$.ajax({
			url: base_url + 'master/flow/apiCountFlow',
			type: 'POST',
			data: { 
					'flow_group_id' : flow_group_id,
					'_token' : $('meta[name="csrf-token"]').attr('content')
					},
			dataType: 'json',
			error: function(data){
				$('#flow_no').empty();
				swal({
		          title: "ERROR",
		          text: "Fetching data error!",
		          type: "warning"
		        })
			},
			success: function(data){
				var max = data.count + 1;

				$('#flow_no,#flow_prev').empty();
				for(i = 1; i <= max; i++)
				{
					$('#flow_no,#flow_prev').append('<option value="' + i + '">' + i + '</option>');
				}

				$('#flow_no, #flow_prev').selectpicker('refresh');
			}
		});
	});
});