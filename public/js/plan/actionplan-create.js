$(document).ready(function(){
	Dropzone.autoDiscover = false;
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
		/*paramName: "file",*/
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
			/*$.ajax({
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
			});*/
			getPreviousUploaded();
		}
	});

	/*$.get(base_url + "/dropzone/getPreviousUploaded", function(data){
		console.log(data);
		
	});*/


	/*Dropzone.options.uploadFileArea = {
		init: function() {
			this.on("addedfile", function(file) { alert('ooo'); });
			thisDropzone = this;

			alert('kk');

			$.get(base_url + "/dropzone/getPreviousUploaded", function(data){
				$.each(data, function(key, value){
					var mockFile = { name: value.name, size: value.size };
					thisDropzone.options.addedfile.call(thisDropzone, mockFile);
					//thisDropzone.options.thumbnail.call(thisDropzone, mockFile, );
				});
			});
		}
	};*/
	/*myDropzone.on('success', function(file){
		alert(file.name);
	});*/

	myDropzone.getAcceptedFiles();

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

	function getPreviousUploaded() {
		$('#uploadFileArea').empty();

		$.ajax({
			url: base_url + "/dropzone/getPreviousUploaded",
			type: "GET",
			dataType: "json",
			success: function(data) {
				/*console.log(data);*/
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