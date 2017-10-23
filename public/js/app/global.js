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

function formatSmallMonth(tanggal) { 
	//tanggal format 2017-10-31
	var smallMonth = [];

	smallMonth['01'] = 'Jan';
	smallMonth['02'] = 'Feb';
	smallMonth['03'] = 'Mar';
	smallMonth['04'] = 'Apr';
	smallMonth['05'] = 'May';
	smallMonth['06'] = 'Jun';
	smallMonth['07'] = 'Jul';
	smallMonth['08'] = 'Aug';
	smallMonth['09'] = 'Sep';
	smallMonth['10'] = 'Oct';
	smallMonth['11'] = 'Nov';
	smallMonth['12'] = 'Dec';

	var result = '';
	var tmp = tanggal.split('-');

	result = tmp[2] + '-' + smallMonth[tmp[1]] + '-' + tmp[0];

	return result;
}