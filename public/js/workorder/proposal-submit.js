$(document).ready(function(){
	Dropzone.autoDiscover = false;
	
	var myToken = $('meta[name="csrf-token"]').attr('content');
	var myDropzone = new Dropzone("div#uploadFileArea", {
		url: base_url + "/dropzone/uploadFiles",
		params: {
			_token: myToken
		},
		addRemoveLinks: true,
		clickable: true,
		maxFilesize: 10,
		accept: function(file, done) {
			done();
		},
		error: function(file, response){
			alert(response);
			getPreviousUploaded();
		},
		success: function(file, response){
			console.log(response);
		},
		init: function() {
			getPreviousUploaded();
		}
	});

	myDropzone.getAcceptedFiles();

	myDropzone.on('removedfile', function(file){
		$.ajax({
			url: base_url + "/dropzone/removeFile",
			type: "POST",
			dataType: "json",
			data: {
				'filename' : file.name,
				_token: myToken
			},
			success: function(data) {
				if(data=='success') {
					alert('File has been removed from server.');
				}else{
					alert('Failed to removing file from server.');
				}
			}
		});
	});

	//cost number format
	formatMoney('#proposal_cost', '#format_proposal_cost');

	//media cost print number format
	formatMoney('#proposal_media_cost_print', '#format_proposal_media_cost_print');

	//media cost other number format
	formatMoney('#proposal_media_cost_other', '#format_proposal_media_cost_other');

	//total offering number format
	formatMoney('#proposal_total_offering', '#format_proposal_total_offering');

	$('#proposal_cost, #proposal_media_cost_print, #proposal_media_cost_other').keyup(function(){
		var result = parseFloat($('#proposal_cost').val()) + parseFloat($('#proposal_media_cost_print').val()) + parseFloat($('#proposal_media_cost_other').val());
		$('#proposal_total_offering').val(result);
		var format_result = previewMoney($('#proposal_total_offering').val());
		$('#format_proposal_total_offering').empty().append(format_result);
	});

	//add offering
	$('#btn_add_offering').click(function(){
    	var tr = '';
    	tr += '<tr>';   	
    	tr += '<td><input type="text" name="offering_post_cost[]" class="form-control" value="' + $('#proposal_cost').val() + '" readonly></td>';
    	tr += '<td><input type="text" name="offering_post_media_cost_print[]" class="form-control" value="' + $('#proposal_media_cost_print').val() + '" readonly></td>';
    	tr += '<td><input type="text" name="offering_post_media_cost_other[]" class="form-control" value="' + $('#proposal_media_cost_other').val() + '" readonly></td>';
    	tr += '<td><input type="text" name="offering_post_total_offering[]" class="form-control" value="' + $('#proposal_total_offering').val() + '" readonly></td>';
    	tr += '<td><a href="javascript:void(0)" class="btn btn-danger btn-offering-delete">Remove</a></td>';
    	tr += '</tr>';
    	$('#offering_post tbody').append(tr);
    });

    //delete offering
    $('body').on('click','.btn-offering-delete', function(e){
		e.preventDefault();
		$(this).closest('tr').remove();
		$(this).closest('headInfo').remove();
	});

	function getPreviousUploaded() {
		$('#uploadFileArea').empty();

		$.ajax({
			url: base_url + "/dropzone/getPreviousUploaded",
			type: "GET",
			dataType: "json",
			success: function(data) {
				$.each(data.files, function(key, value){
					var mockFile = { name: value.name, size: value.size };
					myDropzone.options.addedfile.call(myDropzone, mockFile);
					myDropzone.options.thumbnail.call(myDropzone, mockFile, base_url + "uploads/tmp/" + data._id + "/" + value.name);
					myDropzone.options.complete.call(myDropzone, mockFile);
				});
			}
		});
	}
});