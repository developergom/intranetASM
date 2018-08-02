var myToken = $('meta[name="csrf-token"]').attr('content');
var sales_agents = [];
var agenda_type = [];
var agenda_start_date = '';
var agenda_end_date = '';

$(document).ready(function() {
	$('#btn_export_report').attr('disabled', true);
	$('#btn_generate_report').click(function() {
		generate_report();
	});

	$('#btn_clear_report').click(function() {
		refresh_report_variable();
	});

	$('#btn_export_report').click(function() {
		var currentTime = new Date($.now());
		$('#grid-data-result').table2excel({
			exclude: ".noExl",
			name: "Report Agenda",
			filename: "report_agenda" + currentTime.getDate() + currentTime.getMonth() + currentTime.getFullYear() + "_" + currentTime.getHours() + "_" + currentTime.getMinutes() + "_" + currentTime.getSeconds()
		});
	});
});

function generate_report() {
	sales_agents = $('#sales_agent').val();
	agenda_types = $('#agenda_type').val();
	agenda_start_date = $('#agenda_start_date').val();
	agenda_end_date = $('#agenda_end_date').val();

	/*console.log("Media " + media_ids);
	console.log("Offer period_start " + offer_period_start);
	console.log("Offer period_end " + offer_period_end);*/

	if((agenda_start_date != '') && (agenda_end_date == '')) {
		swal('Agenda End Date must be filled in.');
		$('#agenda_end_date').focus();
	}else if((agenda_start_date == '') && (agenda_end_date != '')) {
		swal('Agenda Start Date must be filled in.');
		$('#agenda_start_date').focus();
	}else{
		$.ajax({
			url: base_url + 'report/api/generateAgendaReport',
			dataType: 'json',
			type: 'POST',
			data: {
				_token: myToken,
				sales_agents : sales_agents,
				agenda_types : agenda_types,
				agenda_start_date : agenda_start_date,
				agenda_end_date : agenda_end_date
			},
			error: function(data) {
				console.log('error');
				console.log(sales_agents);
				console.log(agenda_types);
				console.log(agenda_start_date);
				console.log(agenda_end_date);
				console.log(data);
			},
			success: function(data) {
				console.log(data);
				var html = '';
				var no = 1;
				$('#grid-data-result tbody').empty();
				$.each(data.result, function(key, value){
					html += '<tr>';
					html += '<td>'  + no + '</td>';
					html += '<td>'  + value.agenda_id + '</td>';
					html += '<td>'  + value.agenda_type_name + '</td>';
					html += '<td>'  + value.agenda_date + '</td>';
					html += '<td>'  + value.agenda_desc + '</td>';
					
					if (value.agenda_is_report == 1)
					{
						html += '<td>Reported</td>';
					} else {
						html += '<td>Not Reported</td>';
					}
					
					if(value.agenda_meeting_time != null)
					{
						html += '<td>'  + value.agenda_meeting_time + '</td>';
					} else {
						html += '<td>-</td>';
					}
					
					if(value.agenda_report_time != null)
					{
						html += '<td>'  + value.agenda_report_time + '</td>';
					} else {
						html += '<td>-</td>';
					}
					
					if(value.agenda_report_desc != null)
					{
						html += '<td>'  + value.agenda_report_desc + '</td>';
					} else {
						html += '<td>-</td>';
					}

					html += '<td>'  + value.user_firstname + " " + value.user_lastname + '</td>';
					html += '<td>'  + value.client_name + '</td>';
					html += '</tr>';
					no++;
				});

				$('#grid-data-result tbody').append(html);
				$('#btn_export_report').attr('disabled', false);
			}
		});
	}

	
}

function refresh_report_variable() {
	agenda_types = [];
	sales_agents = [];
	offer_period_start = '';
	offer_period_end = '';

	$('#agenda_type').val('');
	$('#sales_agent').val('');
	$('#agenda_start_date').val('');
	$('#agenda_end_date').val('');

	$('#sales_agent').selectpicker('refresh');
	$('#agenda_type').selectpicker('refresh');

	$('#grid-data-result tbody').empty();
	$('#btn_export_report').attr('disabled', true);
}