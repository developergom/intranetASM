function generateFlowViz(flow_group_id, current = 0) {
	$.ajax({
		url: base_url + 'master/flow/apiGetFlow',
		type: 'POST',
		data: { 
				'flow_group_id' : flow_group_id,
				'_token' : $('meta[name="csrf-token"]').attr('content')
				},
		dataType: 'json',
		error: function(data){
			console.log('error ' + data);
		},
		success: function(data){
			$('#viz-container').empty();
			$('#viz-container').append('<h5>Flow Group Stored</h5>');
			
			$.each(data.data, function(key, value) {
				//$('#viz-container').append('<span class="badge">' +  + '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
				var html = '';
				html += '<div class="dropdown-basic-demo">';
				html += '<ul class="dropdown-menu ' + ((current==value.flow_no) ? '' : 'bgm-blue') + '">';
				html += '<li role="presentation">';
				html += '<a href="javascript:void(0)" role="menuitem"><b>' + value.flow_no + '. ' + value.flow_name + '</b></a>';
				html += '</li>';
				html += '<li role="presentation">';
				html += '<a href="javascript:void(0)" role="menuitem">Next : ' + value.flow_next + '</a>';
				html += '</li>';
				html += '<li role="presentation">';
				html += '<a href="javascript:void(0)" role="menuitem">Prev : ' + value.flow_prev  + '</a>';
				html += '</li>';
				html += '<li role="presentation">';
				html += '<a href="javascript:void(0)" role="menuitem">By : ' + value.flow_by + '</a>';
				html += '</li>';
				html += '<li role="presentation">';
				html += '<a href="javascript:void(0)" role="menuitem">Using Optional : ' + ((value.flow_using_optional=='1') ? 'Yes' : 'No')  + '</a>';
				html += '</li>';
				if(value.flow_using_optional=='1') {
					html += '<li role="presentation">';
					html += '<a href="javascript:void(0)" role="menuitem">Next Optional : ' + value.flow_next_optional + '</a>';
					html += '</li>';
					html += '<li role="presentation">';
					html += '<a href="javascript:void(0)" role="menuitem">Condition : ' + value.flow_condition + ' ' + value.flow_condition_value + '</a>';
					html += '</li>';
				}
				html += '</ul>';
				html += '</div>';
				console.log(html);
				$('#viz-container').append(html);
			});
		}
	});
}