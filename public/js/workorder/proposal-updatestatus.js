$(document).ready(function(){
	//cost number format
	formatMoney('#proposal_deal_cost', '#format_proposal_deal_cost');

	//media cost print number format
	formatMoney('#proposal_deal_media_cost_print', '#format_proposal_deal_media_cost_print');

	//media cost other number format
	formatMoney('#proposal_deal_media_cost_other', '#format_proposal_deal_media_cost_other');

	//total offering number format
	formatMoney('#proposal_total_deal', '#format_proposal_total_deal');

	$('#proposal_deal_cost, #proposal_deal_media_cost_print, #proposal_deal_media_cost_other').keyup(function(){
		var result = parseFloat($('#proposal_deal_cost').val()) + parseFloat($('#proposal_deal_media_cost_print').val()) + parseFloat($('#proposal_deal_media_cost_other').val());
		$('#proposal_total_deal').val(result);
		var format_result = previewMoney($('#proposal_total_deal').val());
		$('#format_proposal_total_deal').empty().append(format_result);
	});
});