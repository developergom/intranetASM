$(document).ready(function(){
	//show choose cost
	
	$('#btn_choose_cost').click(function(cost, mediaprint){
		document.getElementById("costchoose").innerHTML = cost;

		/*
		var buttons = document.getElementsByClassName('btn_choose_cost');
            for (var i=0 ; i < buttons.length ; i++){
              (function(index){
                buttons[index].onclick = function(){
                  alert("I am button " + index);
                };
              })(i)
            }


		$("#costchoose").html(document.getElementById('cost_choose').innerText);
		$("#mediacostprintchoose").html(document.getElementById('media_cost_print_choose').innerText);
		$("#mediacostotherchoose").html(document.getElementById('media_cost_other_choose').innerText);
		$("#totalofferingchoose").html(document.getElementById('total_offering_choose').innerText);
		
		//var message = jQuery("#cost_choose").val();
    	//jQuery("#costchoose").text(message);
		 */
	});

	//cost number format
	formatMoney('#costchoose', '#format_inventory_planner_cost_choose');
	
	//media cost print number format
	formatMoney('#mediacostprintchoose', '#format_inventory_planner_media_cost_print_choose');

	//media cost other number format
	formatMoney('#mediacostotherchoose', '#format_inventory_planner_media_cost_other_choose');

	//total offering number format
	formatMoney('#totalofferingchoose', '#format_inventory_planner_total_offering_choose');

	$('#costchoose, #mediacostprintchoose, #mediacostotherchoose').keyup(function(){
		var result = parseFloat($('#costchoose').val()) + parseFloat($('#mediacostprintchoose').val()) + parseFloat($('#mediacostotherchoose').val());
		$('#totalofferingchoose').val(result);
		var format_result = previewMoney($('#totalofferingchoose').val());
		$('#format_inventory_planner_total_offering_choose').empty().append(format_result);
	});
	
	$('#btn_offering_manual').click(function(){
		$('#costchoose').attr('readonly', false);
		$('#mediacostprintchoose').attr('readonly', false);
		$('#mediacostotherchoose').attr('readonly', false);
		$('#totalofferingchoose').attr('readonly', false);
	});
});

function myFunction(cost,mediaprint,mediaother,total,iddetails) {
    document.getElementById("costchoose").value = cost;
    document.getElementById("mediacostprintchoose").value = mediaprint;
    document.getElementById("mediacostotherchoose").value = mediaother;
    document.getElementById("totalofferingchoose").value = total;
    document.getElementById("costdetailsidchoose").value = iddetails;

    $('#costchoose').attr('readonly', true);
    $('#mediacostprintchoose').attr('readonly', true);
	$('#mediacostotherchoose').attr('readonly', true);
	$('#totalofferingchoose').attr('readonly', true);
    //console.log(cost + " " + mediaprint);
}