$(document).ready(function(){
	

	$('#proposal_deal_cost, #proposal_deal_media_cost_print, #proposal_deal_media_cost_other').keyup(function(){
		var result = parseFloat($('#proposal_deal_cost').val()) + parseFloat($('#proposal_deal_media_cost_print').val()) + parseFloat($('#proposal_deal_media_cost_other').val());
		$('#proposal_total_deal').val(result);
		var format_result = previewMoney($('#proposal_total_deal').val());
		$('#format_proposal_total_deal').empty().append(format_result);
	});

	$('#btn_offering_manual').click(function(){
		$('#proposal_deal_cost').attr('readonly', false);
		$('#proposal_deal_media_cost_print').attr('readonly', false);
		$('#proposal_deal_media_cost_other').attr('readonly', false);
		$('#proposal_total_deal').attr('readonly', false);

		document.getElementById("proposal_deal_cost").value = '';
    	document.getElementById("proposal_deal_media_cost_print").value = '';
    	document.getElementById("proposal_deal_media_cost_other").value = '';
    	document.getElementById("proposal_total_deal").value = '';

    	document.getElementById("format_proposal_deal_cost").innerText = '';
    	document.getElementById("format_proposal_deal_media_cost_print").innerText = '';
    	document.getElementById("format_proposal_deal_media_cost_other").innerText = '';
    	document.getElementById("format_proposal_total_deal").innerText = '';

    	//cost number format
		formatMoney('#proposal_deal_cost', '#format_proposal_deal_cost');

		//media cost print number format
		formatMoney('#proposal_deal_media_cost_print', '#format_proposal_deal_media_cost_print');

		//media cost other number format
		formatMoney('#proposal_deal_media_cost_other', '#format_proposal_deal_media_cost_other');

		//total offering number format
		formatMoney('#proposal_total_deal', '#format_proposal_total_deal');

	});
});

function myFunction(cost,mediaprint,mediaother,total,iddetails,status_cost) {
    document.getElementById("proposal_deal_cost").value = cost;
    document.getElementById("proposal_deal_media_cost_print").value = mediaprint;
    document.getElementById("proposal_deal_media_cost_other").value = mediaother;
    document.getElementById("proposal_total_deal").value = total;
    document.getElementById("proposal_cost_details_id_deal").value = iddetails;
    document.getElementById("status_cost_deal").value = status_cost;

    $('#proposal_deal_cost').attr('readonly', true);
    $('#proposal_deal_media_cost_print').attr('readonly', true);
	$('#proposal_deal_media_cost_other').attr('readonly', true);
	$('#proposal_total_deal').attr('readonly', true);
    //console.log(cost + " " + mediaprint); 

    document.getElementById("format_proposal_deal_cost").innerText = "";
    document.getElementById("format_proposal_deal_media_cost_print").innerText = "";
    document.getElementById("format_proposal_deal_media_cost_other").innerText = "";
    document.getElementById("format_proposal_total_deal").innerText = "";

    //cost number format
	formatMoney('#proposal_deal_cost', '#format_proposal_deal_cost');

	//media cost print number format
	formatMoney('#proposal_deal_media_cost_print', '#format_proposal_deal_media_cost_print');

	//media cost other number format
	formatMoney('#proposal_deal_media_cost_other', '#format_proposal_deal_media_cost_other');

	//total offering number format
	formatMoney('#proposal_total_deal', '#format_proposal_total_deal');
}

function dropdownTip(valueOpt){
	//var valueOpt = document.getElementById('status').value;
	if (valueOpt == 2){
		document.getElementById("proposal_deal_cost").value = 0;
		document.getElementById("proposal_deal_media_cost_print").value = 0;
		document.getElementById("proposal_deal_media_cost_other").value = 0;
		document.getElementById("proposal_total_deal").value = 0;
	} else {
		document.getElementById("proposal_deal_cost").value = '';
		document.getElementById("proposal_deal_media_cost_print").value = '';
		document.getElementById("proposal_deal_media_cost_other").value = '';
		document.getElementById("proposal_total_deal").value = '';
	}

}