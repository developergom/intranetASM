$(document).ready(function(){
	/*Dropzone.autoDiscover = false;*/
	/*$('div#upload_file_area').dropzone({
		url: '/test'
	});*/
	var myToken = $('meta[name="csrf-token"]').attr('content');
	var myDropzone = new Dropzone("div#uploadFileArea", {
		url: base_url + "/dropzone/uploadFiles",
		params: {
			_token: myToken
		},
		addRemoveLinks: true,
		clickable: true,
		paramName: "file",
		maxFilesize: 10,
		accept: function(file, done) {
			done();
		}
	});

	/*myDropzone.on('success', function(file){
		alert(file.name);
	});*/

	myDropzone.on('removedfile', function(file){
		/*myDropzone.removeFile(file);*/

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

	/*myDropzone.autoDiscover = false;
	myDropzone.options.uploadFileArea = {
		paramName: "file",
		maxFilesize: 10,
		addRemoveLinks: dictCancelUploadConfirmation,
		uploadMultiple: true,
		clickable: true,
		accept: function(file, done) {

		}
	}*/
});