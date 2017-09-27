$(document).ready(function(){
	tinymce.init({ 
		selector:'textarea.form-control',
		height: 200,
  		menubar: false,
  		toolbar: [
				    'undo redo | styleselect | bold italic | alignleft aligncenter alignright | fontsizeselect'
				  ]
  	});
});

function previewMoney(inputValue){
	return inputValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}