$(document).ready(function(){
	toggleEditionDate();

	$('#view_type').change(function(){
		toggleEditionDate();
	});

	$('#btn-process').click(function(){
		var media_id = $("#media_id").val();
		var year = $("#year").val();
		var month = $("#month").val();
		var view_type = $("#view_type").val();
		var edition_date = $("#edition_date").val();

		$.ajax({
			url: base_url + 'workorder/posisi_iklan/apiCheckCode',
			dataType: 'json',
			type: 'POST',
			data: {
				'media_id': media_id,
				'year': year,
				'month': month,
				'view_type' : view_type,
				'edition_date' : edition_date,
				'_token': $('meta[name="csrf-token"]').attr('content')
			},
			error: function(response) {
				swal('Error', 'There is an error while communicating with server.', 'error');
			},
			success: function(response) {
				if(response.status==true) {
					$('#posisi_iklan_code').val(response.code);

					$.ajax({
						url: base_url + 'workorder/summary/api/generatePosisiIklan',
						dataType: 'json',
						type: 'POST',
						data: {
							'media_id': media_id,
							'year': year,
							'month': month,
							'view_type' : view_type,
							'edition_date' : edition_date,
							'_token': $('meta[name="csrf-token"]').attr('content')
						},
						error: function(response) {
							swal('Error', 'There is an error while communicating with server.', 'error');
						},
						success: function(response) {

							if(response.length > 0)
							{
								console.log(response);
								var html = '';
								$('#result_container').empty().append('Loading . . . ');

								if(view_type=='print')
								{
									$.each(response, function(key, value){
										html += '<h6>' + value.index + '</h6>';
										html += '<div class="table-responsive"><table class="table">';
											html += '<thead>';
												html += '<tr>';
													html += '<th>' + '<input type="checkbox" id="checkAllPrint" class="check-print-parent">' + '</th>';
													html += '<th>' + 'BIRO IKLAN' + '</th>';
													html += '<th>' + 'JUDUL IKLAN' + '</th>';
													html += '<th>' + 'INDUSTRI' + '</th>';
													html += '<th>' + 'SALES AGENT' + '</th>';
													html += '<th>' + 'UKURAN' + '</th>';
													html += '<th>' + 'REMARKS' + '</th>';
													html += '<th>' + 'HAL' + '</th>';
													html += '<th>' + 'MATERI' + '</th>';
													html += '<th>' + 'SALES ORDER' + '</th>';
													html += '<th>' + 'NETTO' + '</th>';
													html += '<th>' + 'PPN' + '</th>';
													html += '<th>' + 'JUMLAH' + '</th>';
												html += '</tr>';
											html += '</thead>';
											html += '<tbody>';
											$.each(value.items, function(k, v){
												html += '<tr>';
													html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkPrint[' + k + ']" id="checkPrint-' + k + '" class="check-print-child">' + '</td>';
													html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
													html += '<td>' + '<input type="hidden" name="proposal_name[' + k + ']" value="' + v.proposal_name + '">' + v.proposal_name + '</td>';
													html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
													html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
													html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
													html += '<td>' + v.summary_item_remarks + '</td>';
													html += '<td>' + '<input type="text" style="width:120px;" name="print_posisi_iklan_page_no[' + k + ']" class="form-control" placeholder="Hal">' + '</td>';
													html += '<td>' + '<input type="text" style="width:120px;" name="print_posisi_iklan_materi[' + k + ']" class="form-control" placeholder="Materi">' + '</td>';
													html += '<td>' + '<input type="text" style="width:120px;" name="print_posisi_iklan_sales_order[' + k + ']" class="form-control" placeholder="Sales Order">' + '</td>';
													html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
													html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + Math.floor(0.1 * parseInt(v.summary_item_nett)) + '">' + previewMoney(Math.floor(0.1 * parseInt(v.summary_item_nett))) + '</td>';
													html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + Math.floor(1.1 * parseInt(v.summary_item_nett)) + '">' + previewMoney(Math.floor(parseInt(v.summary_item_nett) * 1.1)) + '</td>';
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
												html += '<th>' + '<input type="checkbox" id="checkAllDigital" class="check-digital-parent">' + '</th>';
												html += '<th>' + 'PERIODE TAYANG' + '</th>';
												html += '<th>' + 'BIRO IKLAN' + '</th>';
												html += '<th>' + 'JUDUL IKLAN' + '</th>';
												html += '<th>' + 'INDUSTRI' + '</th>';
												html += '<th>' + 'SALES AGENT' + '</th>';
												html += '<th>' + 'UKURAN' + '</th>';
												html += '<th>' + 'POSISI' + '</th>';
												html += '<th>' + 'REMARKS' + '</th>';
												html += '<th>' + 'KANAL' + '</th>';
												html += '<th>' + 'ORDER DIGITAL' + '</th>';
												html += '<th>' + 'MATERI' + '</th>';
												html += '<th>' + 'STATUS MATERI' + '</th>';
												html += '<th>' + 'CAPTURE MATERI' + '</th>';
												html += '<th>' + 'SALES ORDER' + '</th>';
												html += '<th>' + 'NETTO' + '</th>';
												html += '<th>' + 'PPN' + '</th>';
												html += '<th>' + 'JUMLAH' + '</th>';
											html += '</tr>';
										html += '</thead>';
										html += '<tbody>';
										$.each(response, function(k, v){
											html += '<tr>';
												html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkDigital[' + k + ']" id="checkDigital-' + k + '" class="check-digital-child">' + '</td>';
												html += '<td>' + v.summary_item_period_start + ' s/d ' + v.summary_item_period_end + '</td>';
												html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
												html += '<td>' + '<input type="hidden" name="proposal_name[' + k + ']" value="' + v.proposal_name + '">' + v.proposal_name + '</td>';
												html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
												html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
												html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
												html += '<td>' + v.rate_name + '</td>';
												html += '<td>' + v.summary_item_remarks + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_canal[' + k + ']" class="form-control" placeholder="Kanal">' + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_order_digital[' + k + ']" class="form-control" placeholder="Order Digital">' + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_materi[' + k + ']" class="form-control" placeholder="Materi">' + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_status_materi[' + k + ']" class="form-control" placeholder="Status Materi">' + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_capture_materi[' + k + ']" class="form-control" placeholder="Capture Materi">' + '</td>';
												html += '<td>' + '<input type="text" style="width:120px;" name="digital_posisi_iklan_sales_order[' + k + ']" class="form-control" placeholder="Sales Order">' + '</td>';
												html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
												html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + Math.floor(0.1 * parseInt(v.summary_item_nett)) + '">' + previewMoney(Math.floor(0.1 * parseInt(v.summary_item_nett))) + '</td>';
												html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + Math.floor(1.1 * parseInt(v.summary_item_nett)) + '">' + previewMoney(Math.floor(parseInt(v.summary_item_nett) * 1.1)) + '</td>';
											html += '</tr>';
										});
										html += '</tbody>';
									html += '</table></div>';
									html += '<br/><br/>';
								}else{

								}

								$('#result_container').empty().append(html);
							}else{
								swal('Please Try Again', 'No data found.', 'warning');
							}
							
						}
					})
				}else{
					swal('Code Existed', 'Posisi Iklan with these parameters has been generated before.', 'warning');
				}
			}
		});

		
	});

	$('body').on('change', '#checkAllDigital', function() {
		if($('#checkAllDigital').prop('checked')) {
			$('.check-digital-child').prop('checked', true);
		}else{
			$('.check-digital-child').prop('checked', false);
		}
		
	});

	$('body').on('change', '#checkAllPrint', function() {
		if($('#checkAllPrint').prop('checked')) {
			$('.check-print-child').prop('checked', true);
		}else{
			$('.check-print-child').prop('checked', false);
		}
		
	});
});

function toggleEditionDate()
{
	if($("#view_type").val()=='print') {
		$('#edition_date_container').show();
		$('#month_container').hide();
		$('#year_container').hide();
	}else{
		$('#edition_date_container').hide();
		$('#month_container').show();
		$('#year_container').show();
	}
}