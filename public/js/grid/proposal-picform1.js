$(document).ready(function() {
	$('#pic_container').hide();

	$('#skip_production').change(function(){
		if($(this).val()=='0') {
			$('#pic_container').show();
			$('#pic').prop('required', 'true');
		}else{
			$('#pic_container').hide();
			$('#pic').removeAttr('required');
		}
	});
	
});