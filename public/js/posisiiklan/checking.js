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

		$('#media_cost').empty();
		$('#cost_pro').empty();

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
				'summary_item_type' : 'media_cost',
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
					$('#media_cost').empty().append('Loading . . . ');

					if(view_type=='print')
					{
						$.each(response, function(key, value){
							html += '<h6>' + value.index + '</h6>';
							html += '<h6>Media Cost</h6>';
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
										html += '<th>' + 'HAL/POSISI' + '</th>';
										html += '<th>' + 'MATERI' + '</th>';
										html += '<th>' + 'SALES ORDER' + '</th>';
										html += '<th>' + 'PO PERJANJIAN' + '</th>';
										html += '<th>' + 'NETTO' + '</th>';
										html += '<th>' + 'PPN' + '</th>';
										html += '<th>' + 'JUMLAH' + '</th>';
										html += '<th>' + 'STATUS' + '</th>';
										html += '<th>' + 'SOURCE' + '</th>';
										html += '<th>' + 'ACTION' + '</th>';
									html += '</tr>';
								html += '</thead>';
								html += '<tbody>';
								$.each(value.items, function(k, v){
									html += '<tr>';
										html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkPrint[' + k + ']" id="checkPrint-' + k + '" class="check-print-child">' + '</td>';
										html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
										html += '<td>' + '<input type="hidden" name="summary_item_title[' + k + ']" value="' + v.summary_item_title + '">' + v.summary_item_title + '</td>';
										html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
										html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
										html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
										html += '<td>' + v.summary_item_remarks + '</td>';
										html += '<td>' + v.page_no + '</td>';
										html += '<td>' + v.summary_item_materi + '</td>';
										html += '<td>' + v.summary_item_sales_order + '</td>';
										html += '<td>' + v.summary_item_po_perjanjian + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + v.summary_item_ppn + '">' + previewMoney(v.summary_item_ppn) + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + v.summary_item_total + '">' + previewMoney(v.summary_item_total) + '</td>';
										html += '<td>' + '<span class="badge">' + v.summary_item_viewed + '</span></td>';
										html += '<td>' + '<span class="badge">' + v.source_type + '</span></td>';
										if(canupdate==true){
											html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '<button type="button" class="btn btn-warning btn-lock" data-id="' + v.summary_item_id + '">Lock</button>') + '</td>';
										}else{
											html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '-') + '</td>';
										}
									html += '</tr>';
								});
								html += '</tbody>';
							html += '</table></div>';
							html += '<br/><br/>';
						});
						
					}else if(view_type=='digital')
					{
						html += '<h6>Media Cost</h6>';
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
									html += '<th>' + 'RATE' + '</th>';
									html += '<th>' + 'REMARKS' + '</th>';
									html += '<th>' + 'HAL/POSISI' + '</th>';
									html += '<th>' + 'KANAL' + '</th>';
									html += '<th>' + 'ORDER DIGITAL' + '</th>';
									html += '<th>' + 'MATERI' + '</th>';
									html += '<th>' + 'STATUS MATERI' + '</th>';
									html += '<th>' + 'CAPTURE MATERI' + '</th>';
									html += '<th>' + 'SALES ORDER' + '</th>';
									html += '<th>' + 'PO PERJANJIAN' + '</th>';
									html += '<th>' + 'NETTO' + '</th>';
									html += '<th>' + 'PPN' + '</th>';
									html += '<th>' + 'JUMLAH' + '</th>';
									html += '<th>' + 'STATUS' + '</th>';
									html += '<th>' + 'SOURCE' + '</th>';
									html += '<th>' + 'ACTION' + '</th>';
								html += '</tr>';
							html += '</thead>';
							html += '<tbody>';
							$.each(response, function(k, v){
								html += '<tr>';
									html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkDigital[' + k + ']" id="checkDigital-' + k + '" class="check-digital-child">' + '</td>';
									html += '<td>' + v.summary_item_period_start + ' s/d ' + v.summary_item_period_end + '</td>';
									html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
									html += '<td>' + '<input type="hidden" name="proposal_name[' + k + ']" value="' + v.summary_item_title + '">' + v.summary_item_title + '</td>';
									html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
									html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
									html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
									html += '<td>' + v.rate_name + '</td>';
									html += '<td>' + v.summary_item_remarks + '</td>';
									html += '<td>' + v.page_no + '</td>';
									html += '<td>' + v.summary_item_canal + '</td>';
									html += '<td>' + v.summary_item_order_digital + '</td>';
									html += '<td>' + v.summary_item_materi + '</td>';
									html += '<td>' + v.summary_item_status_materi + '</td>';
									html += '<td>' + v.summary_item_capture_materi + '</td>';
									html += '<td>' + v.summary_item_sales_order + '</td>';
									html += '<td>' + v.summary_item_po_perjanjian + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + v.summary_item_ppn + '">' + previewMoney(v.summary_item_ppn) + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + v.summary_item_total + '">' + previewMoney(v.summary_item_total) + '</td>';
									html += '<td>' + '<span class="badge">' + v.summary_item_viewed + '</span></td>';
									html += '<td>' + '<span class="badge">' + v.source_type + '</span></td>';
									if(canupdate==true){
										html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '<button type="button" class="btn btn-warning btn-lock" data-id="' + v.summary_item_id + '">Lock</button>') + '</td>';
									}else{
										html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '-') + '</td>';
									}
								html += '</tr>';
							});
							html += '</tbody>';
						html += '</table></div>';
						html += '<br/><br/>';
					}else{

					}

					$('#media_cost').empty().append(html);
				}else{
					swal('Please Try Again', 'No data media cost found.', 'warning');
				}
				
			}
		});
		
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
				'summary_item_type' : 'cost_pro',
				'_token': $('meta[name="csrf-token"]').attr('content')
			},
			error: function(response) {
				swal('Error', 'There is an error while communicating with server.', 'error');
			},
			success: function(response) {

				if(response.length > 0)
				{
					var html = '';
					$('#cost_pro').empty().append('Loading . . . ');

					if(view_type=='print')
					{
						$.each(response, function(key, value){
							html += '<h6>Cost Pro</h6>';
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
										html += '<th>' + 'HAL/POSISI' + '</th>';
										html += '<th>' + 'MATERI' + '</th>';
										html += '<th>' + 'SALES ORDER' + '</th>';
										html += '<th>' + 'PO PERJANJIAN' + '</th>';
										html += '<th>' + 'NETTO' + '</th>';
										html += '<th>' + 'PPN' + '</th>';
										html += '<th>' + 'JUMLAH' + '</th>';
										html += '<th>' + 'STATUS' + '</th>';
										html += '<th>' + 'SOURCE' + '</th>';
										html += '<th>' + 'ACTION' + '</th>';
									html += '</tr>';
								html += '</thead>';
								html += '<tbody>';
								$.each(value.items, function(k, v){
									html += '<tr>';
										html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkPrint[' + k + ']" id="checkPrint-' + k + '" class="check-print-child">' + '</td>';
										html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
										html += '<td>' + '<input type="hidden" name="summary_item_title[' + k + ']" value="' + v.summary_item_title + '">' + v.summary_item_title + '</td>';
										html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
										html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
										html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
										html += '<td>' + v.summary_item_remarks + '</td>';
										html += '<td>' + v.page_no + '</td>';
										html += '<td>' + v.summary_item_materi + '</td>';
										html += '<td>' + v.summary_item_sales_order + '</td>';
										html += '<td>' + v.summary_item_po_perjanjian + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + v.summary_item_ppn + '">' + previewMoney(v.summary_item_ppn) + '</td>';
										html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + v.summary_item_total + '">' + previewMoney(v.summary_item_total) + '</td>';
										html += '<td>' + '<span class="badge">' + v.summary_item_viewed + '</span></td>';
										html += '<td>' + '<span class="badge">' + v.source_type + '</span></td>';
										if(canupdate==true){
											html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '<button type="button" class="btn btn-warning btn-lock" data-id="' + v.summary_item_id + '">Lock</button>') + '</td>';
										}else{
											html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '-') + '</td>';
										}
									html += '</tr>';
								});
								html += '</tbody>';
							html += '</table></div>';
							html += '<br/><br/>';
						});
						
					}else if(view_type=='digital')
					{
						html += '<h6>Cost Pro</h6>';
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
									html += '<th>' + 'RATE' + '</th>';
									html += '<th>' + 'REMARKS' + '</th>';
									html += '<th>' + 'HAL/POSISI' + '</th>';
									html += '<th>' + 'KANAL' + '</th>';
									html += '<th>' + 'ORDER DIGITAL' + '</th>';
									html += '<th>' + 'MATERI' + '</th>';
									html += '<th>' + 'STATUS MATERI' + '</th>';
									html += '<th>' + 'CAPTURE MATERI' + '</th>';
									html += '<th>' + 'SALES ORDER' + '</th>';
									html += '<th>' + 'NETTO' + '</th>';
									html += '<th>' + 'PPN' + '</th>';
									html += '<th>' + 'JUMLAH' + '</th>';
									html += '<th>' + 'STATUS' + '</th>';
									html += '<th>' + 'SOURCE' + '</th>';
									html += '<th>' + 'ACTION' + '</th>';
								html += '</tr>';
							html += '</thead>';
							html += '<tbody>';
							$.each(response, function(k, v){
								html += '<tr>';
									html += '<td>' + '<input type="hidden" name="summary_item_id[' + k + ']" value="' + v.summary_item_id + '"><input type="checkbox" name="checkDigital[' + k + ']" id="checkDigital-' + k + '" class="check-digital-child">' + '</td>';
									html += '<td>' + v.summary_item_period_start + ' s/d ' + v.summary_item_period_end + '</td>';
									html += '<td>' + '<input type="hidden" name="client_id[' + k + ']" value="' + v.client_id + '">' + v.client_name + '</td>';
									html += '<td>' + '<input type="hidden" name="proposal_name[' + k + ']" value="' + v.summary_item_title + '">' + v.summary_item_title + '</td>';
									html += '<td>' + '<input type="hidden" name="industry_id[' + k + ']" value="' + v.industry_id + '">' + v.industry_name + '</td>';
									html += '<td>' + '<input type="hidden" name="user_id[' + k + ']" value="' + v.user_id + '">' + v.user_firstname + ' ' + v.user_lastname + '</td>';
									html += '<td>' + v.width + 'x' + v.length + ' ' + v.unit_name + '</td>';
									html += '<td>' + v.rate_name + '</td>';
									html += '<td>' + v.summary_item_remarks + '</td>';
									html += '<td>' + v.page_no + '</td>';
									html += '<td>' + v.summary_item_canal + '</td>';
									html += '<td>' + v.summary_item_order_digital + '</td>';
									html += '<td>' + v.summary_item_materi + '</td>';
									html += '<td>' + v.summary_item_status_materi + '</td>';
									html += '<td>' + v.summary_item_capture_materi + '</td>';
									html += '<td>' + v.summary_item_sales_order + '</td>';
									html += '<td>' + v.summary_item_po_perjanjian + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_nett[' + k + ']" value="' + v.summary_item_nett + '">' + previewMoney(v.summary_item_nett) + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_ppn[' + k + ']" value="' + v.summary_item_ppn + '">' + previewMoney(v.summary_item_ppn) + '</td>';
									html += '<td>' + '<input type="hidden" name="posisi_iklan_total[' + k + ']" value="' + v.summary_item_total + '">' + previewMoney(v.summary_item_total) + '</td>';
									html += '<td>' + '<span class="badge">' + v.summary_item_viewed + '</span></td>';
									html += '<td>' + '<span class="badge">' + v.source_type + '</span></td>';
									if(canupdate==true){
										html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '<button type="button" class="btn btn-warning btn-lock" data-id="' + v.summary_item_id + '">Lock</button>') + '</td>';
									}else{
										html += '<td>' + ((v.summary_item_viewed=='COMPLETED') ? '<span class="badge">Locked</span>' : '-') + '</td>';
									}
								html += '</tr>';
							});
							html += '</tbody>';
						html += '</table></div>';
						html += '<br/><br/>';
					}else{

					}

					$('#cost_pro').empty().append(html);
				}else{
					swal('Please Try Again', 'No data cost pro found.', 'warning');
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

	$('body').on('click', '.btn-lock', function() {
		var lock_id = $(this).data('id');
		swal({
			title: "Are you sure want to LOCKING this data?",
			text: "You will not be able to recover this action!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, LOCK it!",
			closeOnConfirm: false
        },
        function(){
			$.ajax({
				url: base_url + 'posisi-iklan/checking/api/locking',
				type: 'POST',
				data: {
					'summary_item_id' : lock_id,
					'_token' : $('meta[name="csrf-token"]').attr('content')
					},
				dataType: 'json',
				error: function() {
					swal("Failed!", "Locking data failed.", "error");
				},
				success: function(data) {
					if(data==100) 
					{
						swal("Locked!", "Your data has been LOCKED.", "success");
						$('#btn-process').click();
					}else{
						swal("Failed!", "Locking data failed.", "error");
					}
				}
			});
		});
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