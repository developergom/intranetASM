$(document).ready(function(){
	$('#btn-process').click(function(){
		var media_id = $("#media_id").val();
		var year = $("#year").val();
		var month = $("#month").val();
		var view_type = $("#view_type").val();

		$.ajax({
			url: base_url + 'workorder/summary/api/generatePosisiIklan',
			dataType: 'json',
			type: 'POST',
			data: {
				'media_id': media_id,
				'year': year,
				'month': month,
				'view_type' : view_type,
				'_token': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				console.log(response);
				var html = '';

				if(view_type=='print')
				{
					$.each(response, function(key, value){
						html += '<h6>' + value.index + '</h6>';
						html += '<div class="table-responsive"><table class="table">';
							html += '<thead>';
								html += '<tr>';
									html += '<th>' + 'BIRO IKLAN' + '</th>';
									html += '<th>' + 'JUDUL IKLAN' + '</th>';
									html += '<th>' + 'INDUSTRI' + '</th>';
									html += '<th>' + 'SALES AGENT' + '</th>';
									html += '<th>' + 'UKURAN' + '</th>';
									html += '<th>' + 'HAL' + '</th>';
									html += '<th>' + 'REMARKS' + '</th>';
									html += '<th>' + 'GROSS' + '</th>';
									html += '<th>' + 'DISC %' + '</th>';
									html += '<th>' + 'NETTO' + '</th>';
									html += '<th>' + 'PPN' + '</th>';
									html += '<th>' + 'JUMLAH' + '</th>';
								html += '</tr>';
							html += '</thead>';
							html += '<tbody>';
							$.each(value.items, function(k, v){
								html += '<tr>';
									html += '<td>' + v.client_name + '</td>';
									html += '<td>' + v.proposal_name + '</td>';
									html += '<td>' + v.industry_name + '</td>';
									html += '<td>' + v.user_firstname + ' ' + v.user_lastname + '</td>';
									html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
									html += '<td>' + v.page_no + '</td>';
									html += '<td>' + v.summary_item_remarks + '</td>';
									html += '<td>' + previewMoney(v.summary_item_gross) + '</td>';
									html += '<td>' + v.summary_item_disc + '</td>';
									html += '<td>' + previewMoney(v.summary_item_nett) + '</td>';
									html += '<td>' + previewMoney(Math.floor(0.1 * parseInt(v.summary_item_nett))) + '</td>';
									html += '<td>' + previewMoney(Math.floor(parseInt(v.summary_item_nett) * 1.1)) + '</td>';
								html += '</tr>';
							});
							html += '</tbody>';
						html += '</table></div>';
						html += '<br/><br/>';
					});
					
				}else if(view_type=='digital')
				{
					html += '<div class="table-responsive"><table class="table">';
						html += '<thead>';
							html += '<tr>';
								html += '<th>' + 'PERIODE TAYANG' + '</th>';
								html += '<th>' + 'BIRO IKLAN' + '</th>';
								html += '<th>' + 'JUDUL IKLAN' + '</th>';
								html += '<th>' + 'INDUSTRI' + '</th>';
								html += '<th>' + 'SALES AGENT' + '</th>';
								html += '<th>' + 'UKURAN' + '</th>';
								html += '<th>' + 'REMARKS' + '</th>';
								html += '<th>' + 'MATERI' + '</th>';
								html += '<th>' + 'GROSS' + '</th>';
								html += '<th>' + 'DISC %' + '</th>';
								html += '<th>' + 'NETTO' + '</th>';
								html += '<th>' + 'PPN' + '</th>';
								html += '<th>' + 'JUMLAH' + '</th>';
							html += '</tr>';
						html += '</thead>';
						html += '<tbody>';
						$.each(response, function(k, v){
							html += '<tr>';
								html += '<td>' + v.summary_item_period_start + ' s/d ' + v.summary_item_period_end + '</td>';
								html += '<td>' + v.client_name + '</td>';
								html += '<td>' + v.proposal_name + '</td>';
								html += '<td>' + v.industry_name + '</td>';
								html += '<td>' + v.user_firstname + ' ' + v.user_lastname + '</td>';
								html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
								html += '<td>' + v.rate_name + '</td>';
								html += '<td>' + v.summary_item_remarks + '</td>';
								html += '<td>' + previewMoney(v.summary_item_gross) + '</td>';
								html += '<td>' + v.summary_item_disc + '</td>';
								html += '<td>' + previewMoney(v.summary_item_nett) + '</td>';
								html += '<td>' + previewMoney(Math.floor(0.1 * parseInt(v.summary_item_nett))) + '</td>';
								html += '<td>' + previewMoney(Math.floor(parseInt(v.summary_item_nett) * 1.1)) + '</td>';
							html += '</tr>';
						});
						html += '</tbody>';
					html += '</table></div>';
					html += '<br/><br/>';
				}else{

				}

				$('#result_container').empty().append(html);
			}
		})
	});
});