$(document).ready(function(){
	tinymce.init({ 
		selector:'textarea.form-control',
		height: 200,
  		menubar: false
  	});
});

function previewMoney(inputValue){
	return inputValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}