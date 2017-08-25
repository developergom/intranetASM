$(document).ready(function(){
	if($('#flow_group_id').val()!='') {
		generateFlowViz($('#flow_group_id').val(), $('#flow_no').val());
	}

	if($('#flow_using_optional').val()=='1') {
		$('.next-optional-container').show();
	}else{
		$('.next-optional-container').hide();
	}

	$('#flow_using_optional').change(function(){
		if($(this).val()=='1') {
			$('.next-optional-container').show();
		}else{
			$('.next-optional-container').hide();
		}
	});

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

		generateFlowViz(flow_group_id);
	});

});