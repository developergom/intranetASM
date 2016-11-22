$(document).ready(function(){
	$('.checkbox-check-all').click(function(){
		var parent = $(this).data('module');
		if($(this).is(':checked'))
		{
			//alert('checked');
			$('.checkbox-item-' + parent).prop('checked',true);
		}else{
			//alert('unchecked');
			$('.checkbox-item-' + parent).prop('checked',false);
		}
	});
});