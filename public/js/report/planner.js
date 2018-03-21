var myToken = $('meta[name="csrf-token"]').attr('content');
var user_ids = [];
var year = '';

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
			name: "Report Planner",
			filename: "report_planner" + currentTime.getDate() + currentTime.getMonth() + currentTime.getFullYear() + "_" + currentTime.getHours() + "_" + currentTime.getMinutes() + "_" + currentTime.getSeconds()
		});
	});
});

function generate_report() {
	user_ids = $('#user_id').val();
	year = $('#year').val();

	console.log(user_ids);

	/*console.log("Media " + media_ids);
	console.log("Offer period_start " + offer_period_start);
	console.log("Offer period_end " + offer_period_end);*/

	if(user_ids==null) {
		swal('Attention', 'Planner must be choosen.', 'warning');
		$('#user_id').focus();
	}else{
		$('#grid-data-result tbody').empty().append('<tr><td colspan="159">Loading...</td></tr>');

		var total_all = [];
		for (var i = 1; i <= 156; i++) {
			total_all[i] = 0;
		}

		$.ajax({
			url: base_url + 'report/api/generatePlannerReport',
			dataType: 'json',
			type: 'POST',
			data: {
				_token: myToken,
				user_ids : user_ids,
				year : year
			},
			error: function(data) {
				console.log('error');
			},
			success: function(data) {
				//console.log(data);
				var html = '';
				var no = 1;

				//$('#grid-data-result tbody').empty().append('<tr><td colspan="159">Loading...</td></tr>');
				$.each(data, function(key, value){
					html += '<tr>';
					html += '<td>'  + no + '</td>';
					html += '<td>'  + value.full_name + '</td>';

					var months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
					$.each(months, function(k,v){
						html += '<td>' + value[v]['1sold']['1direct'] + '</td>';
						html += '<td>' + value[v]['1sold']['2brief'] + '</td>';
						html += '<td>' + value[v]['1sold']['3all'] + '</td>';
						html += '<td>' + value[v]['2not_sold']['1direct'] + '</td>';
						html += '<td>' + value[v]['2not_sold']['2brief'] + '</td>';
						html += '<td>' + value[v]['2not_sold']['3all'] + '</td>';
						html += '<td>' + value[v]['3on_process']['1direct'] + '</td>';
						html += '<td>' + value[v]['3on_process']['2brief'] + '</td>';
						html += '<td>' + value[v]['3on_process']['3all'] + '</td>';
						html += '<td>' + value[v]['4total']['1direct'] + '</td>';
						html += '<td>' + value[v]['4total']['2brief'] + '</td>';
						html += '<td>' + value[v]['4total']['3all'] + '</td>';

						total_all[(k*12)+1] += value[v]['1sold']['1direct'];
						total_all[(k*12)+2] += value[v]['1sold']['2brief'];
						total_all[(k*12)+3] += value[v]['1sold']['3all'];
						total_all[(k*12)+4] += value[v]['2not_sold']['1direct'];
						total_all[(k*12)+5] += value[v]['2not_sold']['2brief'];
						total_all[(k*12)+6] += value[v]['2not_sold']['3all'];
						total_all[(k*12)+7] += value[v]['3on_process']['1direct'];
						total_all[(k*12)+8] += value[v]['3on_process']['2brief'];
						total_all[(k*12)+9] += value[v]['3on_process']['3all'];
						total_all[(k*12)+10] += value[v]['4total']['1direct'];
						total_all[(k*12)+11] += value[v]['4total']['2brief'];
						total_all[(k*12)+12] += value[v]['4total']['3all'];
					});

					html += '<td>' + value['total']['1sold']['1direct'] + '</td>';
					html += '<td>' + value['total']['1sold']['2brief'] + '</td>';
					html += '<td>' + value['total']['1sold']['3all'] + '</td>';
					html += '<td>' + value['total']['2not_sold']['1direct'] + '</td>';
					html += '<td>' + value['total']['2not_sold']['2brief'] + '</td>';
					html += '<td>' + value['total']['2not_sold']['3all'] + '</td>';
					html += '<td>' + value['total']['3on_process']['1direct'] + '</td>';
					html += '<td>' + value['total']['3on_process']['2brief'] + '</td>';
					html += '<td>' + value['total']['3on_process']['3all'] + '</td>';
					html += '<td>' + value['total']['4total']['1direct'] + '</td>';
					html += '<td>' + value['total']['4total']['2brief'] + '</td>';
					html += '<td><strong>' + value['total']['4total']['3all'] + '</strong></td>';

					total_all[(12*12)+1] += value['total']['1sold']['1direct'];
					total_all[(12*12)+2] += value['total']['1sold']['2brief'];
					total_all[(12*12)+3] += value['total']['1sold']['3all'];
					total_all[(12*12)+4] += value['total']['2not_sold']['1direct'];
					total_all[(12*12)+5] += value['total']['2not_sold']['2brief'];
					total_all[(12*12)+6] += value['total']['2not_sold']['3all'];
					total_all[(12*12)+7] += value['total']['3on_process']['1direct'];
					total_all[(12*12)+8] += value['total']['3on_process']['2brief'];
					total_all[(12*12)+9] += value['total']['3on_process']['3all'];
					total_all[(12*12)+10] += value['total']['4total']['1direct'];
					total_all[(12*12)+11] += value['total']['4total']['2brief'];
					total_all[(12*12)+12] += value['total']['4total']['3all'];

					html += '<td>'  + value.full_name + '</td>';
					html += '</tr>';

					no++;
				});

				html += '<tr>';
				html += '<td colspan="2"><strong>Total</strong></td>';
				for (var i = 1; i <= 156; i++) {
					html += '<td><strong>'  + total_all[i] + '</strong></td>';
				};
				html += '<td><strong>Total</strong></td>';
				html += '</tr>';

				$('#grid-data-result tbody').empty().append(html);
				$('#btn_export_report').attr('disabled', false);
			}
		});
	}

	
}

function refresh_report_variable() {
	user_ids = [];
	year = '';

	$('#user_id').val('');
	$('#year').val('');

	$('#user_id').selectpicker('refresh');
	$('#year').selectpicker('refresh');

	$('#grid-data-result tbody').empty();
	$('#btn_export_report').attr('disabled', true);
}