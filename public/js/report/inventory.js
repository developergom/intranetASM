var myToken = $('meta[name="csrf-token"]').attr('content');
var media_ids = [];
var industry_ids = [];
var sell_period_months = [];
var sell_period_years = [];
var offer_period_start = '';
var offer_period_end = '';

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
			name: "Report Inventory",
			filename: "report_inventory" + currentTime.getDate() + currentTime.getMonth() + currentTime.getFullYear() + "_" + currentTime.getHours() + "_" + currentTime.getMinutes() + "_" + currentTime.getSeconds()
		});
	});
});

function generate_report() {
	media_ids = $('#media_id').val();
	industry_ids = $('#industry_id').val();
	sell_period_months = $('#sell_period_id').val();
	sell_period_years = $('#sell_period_year').val();
	offer_period_start = $('#offer_period_start').val();
	offer_period_end = $('#offer_period_end').val();

	/*console.log("Media " + media_ids);
	console.log("Offer period_start " + offer_period_start);
	console.log("Offer period_end " + offer_period_end);*/

	if((offer_period_start != '') && (offer_period_end == '')) {
		swal('Offer Period End must be filled in.');
		$('#offer_period_end').focus();
	}else if((offer_period_start == '') && (offer_period_end != '')) {
		swal('Pffer Period Start must be filled in.');
		$('#offer_period_start').focus();
	}else{
		$.ajax({
			url: base_url + 'report/api/generateInventoryReport',
			dataType: 'json',
			type: 'POST',
			data: {
				_token: myToken,
				media_ids : media_ids,
				industry_ids : industry_ids,
				sell_period_months : sell_period_months,
				sell_period_years : sell_period_years,
				offer_period_start : offer_period_start,
				offer_period_end : offer_period_end
			},
			error: function(data) {
				console.log('error');
			},
			success: function(data) {
				console.log(data);
				var html = '';
				var no = 1;
				var total_inventory_planner_cost = 0;
				var total_inventory_planner_media_cost_print = 0;
				var total_inventory_planner_media_cost_other = 0;
				var total_inventory_planner_total_offering = 0;
				var total_proposal_deal_cost = 0;
				var total_proposal_deal_media_cost_print = 0;
				var total_proposal_deal_media_cost_other = 0;
				var total_proposal_total_deal = 0;
				$('#grid-data-result tbody').empty();
				$.each(data.result, function(key, value){
					html += '<tr>';
					html += '<td>'  + no + '</td>';
					html += '<td>'  + value.inventory_source_name + '</td>';
					html += '<td>'  + value.inventory_planner_title + '</td>';
					html += '<td>'  + value.inventory_planner_desc + '</td>';
					html += '<td>'  + value.inventory_planner_sell_period + '</td>';
					html += '<td>'  + value.inventory_planner_media_name + '</td>';
					html += '<td>'  + value.planner + '</td>';
					html += '<td>'  + previewMoney(value.inventory_planner_cost) + '</td>';
					html += '<td>'  + previewMoney(value.inventory_planner_media_cost_print) + '</td>';
					html += '<td>'  + previewMoney(value.inventory_planner_media_cost_other) + '</td>';
					html += '<td>'  + previewMoney(value.inventory_planner_total_offering) + '</td>';
					html += '<td>'  + value.proposal_no + '</td>';
					html += '<td>'  + value.sales_agent + '</td>';
					html += '<td>'  + value.industry_name + '</td>';
					html += '<td>'  + value.brand_name + '</td>';
					html += '<td>'  + value.proposal_status_name + '</td>';
					html += '<td>'  + previewMoney(value.proposal_deal_cost) + '</td>';
					html += '<td>'  + previewMoney(value.proposal_deal_media_cost_print) + '</td>';
					html += '<td>'  + previewMoney(value.proposal_deal_media_cost_other) + '</td>';
					html += '<td>'  + previewMoney(value.proposal_total_deal) + '</td>';
					html += '</tr>';

					total_inventory_planner_cost += value.inventory_planner_cost;
					total_inventory_planner_media_cost_print += value.inventory_planner_media_cost_print;
					total_inventory_planner_media_cost_other += value.inventory_planner_media_cost_other;
					total_inventory_planner_total_offering += value.inventory_planner_total_offering;
					total_proposal_deal_cost += value.proposal_deal_cost;
					total_proposal_deal_media_cost_print += value.proposal_deal_media_cost_print;
					total_proposal_deal_media_cost_other += value.proposal_deal_media_cost_other;
					total_proposal_total_deal += value.proposal_total_deal;
					no++;
				});

				html += '<tr>';
				html += '<td colspan="7">Total</td>';
				html += '<td>'  + previewMoney(total_inventory_planner_cost) + '</td>';
				html += '<td>'  + previewMoney(total_inventory_planner_media_cost_other) + '</td>';
				html += '<td>'  + previewMoney(total_inventory_planner_media_cost_print) + '</td>';
				html += '<td>'  + previewMoney(total_inventory_planner_total_offering) + '</td>';
				html += '<td colspan="5"></td>';
				html += '<td>'  + previewMoney(total_proposal_deal_cost) + '</td>';
				html += '<td>'  + previewMoney(total_proposal_deal_media_cost_print) + '</td>';
				html += '<td>'  + previewMoney(total_proposal_deal_media_cost_other) + '</td>';
				html += '<td>'  + previewMoney(total_proposal_total_deal) + '</td>';
				html += '</tr>';

				html += '<tr>';
				html += '<td colspan="19">Target</td>';
				html += '<td>'  + ((data.target[0].total_target==null) ? '0' : previewMoney(data.target[0].total_target))  + '</td>';
				html += '</tr>';

				$('#grid-data-result tbody').append(html);
				$('#btn_export_report').attr('disabled', false);
			}
		});
	}

	
}

function refresh_report_variable() {
	media_ids = [];
	industry_ids = [];
	sell_period_months = [];
	sell_period_years = [];
	offer_period_start = '';
	offer_period_end = '';

	$('#media_id').val('');
	$('#industry_id').val('');
	$('#sell_period_id').val('');
	$('#sell_period_year').val('');
	$('#offer_period_start').val('');
	$('#offer_period_end').val('');

	$('#media_id').selectpicker('refresh');
	$('#industry_id').selectpicker('refresh');
	$('#sell_period_id').selectpicker('refresh');
	$('#sell_period_year').selectpicker('refresh');

	$('#grid-data-result tbody').empty();
	$('#btn_export_report').attr('disabled', true);
}