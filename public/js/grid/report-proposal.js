var myToken = $('meta[name="csrf-token"]').attr('content');
var project_task_type_ids = [];
var period_start = '';
var period_end = '';

$(document).ready(function() {
	$('#btn_export_report').attr('disabled', true);
	$('#btn_generate_report').click(function() {
		generate_report();
	});

	$('#btn_clear_report').click(function() {
		refresh_report_variable();
	});

	$('#btn_export_report').click(function() {
		$('#grid-data-result').table2excel({
			exclude: ".noExl",
			name: "Report Proposal GRID",
			filename: "report_proposal_grid"
		});
	});
});

function generate_report() {
	period_start = $('#period_start').val();
	period_end = $('#period_end').val();

	console.log("period_start " + period_start);
	console.log("period_end " + period_end);

	if((period_start != '') && (period_end == '')) {
		alert('Period End must be filled in.');
		$('#period_end').focus();
	}else if((period_start == '') && (period_end != '')) {
		alert('Period Start must be filled in.');
		$('#period_start').focus();
	}else{
		$.ajax({
			url: base_url + 'grid/report-proposal/api/generateReport',
			dataType: 'json',
			type: 'POST',
			data: {
				_token: myToken,
				period_start : period_start,
				period_end : period_end
			},
			error: function(data) {
				console.log('error');
			},
			success: function(data) {
				console.log(data.result);
				var html = '';
				$('#grid-data-result tbody').empty();
				$.each(data.result, function(key, value){
					html += '<tr>';
					html += '<td>'  + value.grid_proposal_name + '</td>';
					html += '<td>'  + value.grid_proposal_deadline + '</td>';
					html += '<td>'  + value.approval_1_name + '</td>';
					html += '<td>'  + value.pic_1_name + '</td>';
					html += '<td>'  + value.pic_2_name + '</td>';
					html += '<td>'  + value.author_name + '</td>';
					html += '<td>'  + value.created_at + '</td>';
					html += '<td>'  + value.grid_proposal_ready_date + '</td>';
					html += '<td>'  + value.grid_proposal_delivery_date + '</td>';
					html += '<td>'  + value.history_date + '</td>';
					html += '<td>'  + value.history_author_name + '</td>';
					html += '<td>'  + value.approval_type_name + '</td>';
					html += '<td>'  + value.grid_proposal_history_text + '</td>';
					html += '</tr>';
				});

				$('#grid-data-result tbody').append(html);
				$('#btn_export_report').attr('disabled', false);
			}
		});
	}

	
}

function refresh_report_variable() {
	period_start = '';
	period_end = '';

	$('#period_start').val('');
	$('#period_end').val('');

	$('#grid-data-result tbody').empty();
	$('#btn_export_report').attr('disabled', true);
}