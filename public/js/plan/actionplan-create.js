$(document).ready(function(){
	var tmp_media_group_id = [];
	collapseAllField();

	$('#media_group_id').change(function(){
		tmp_media_group_id = $(this).val();

		$.ajax({
			url: base_url + 'plan/actionplan/apigetmediapermediagroup',
			type: 'POST',
			dataType: 'json',
			data: {
					media_group_id : tmp_media_group_id,
					'_token' : $('meta[name="csrf-token"]').attr('content')
					},
			error: function(data){
				console.log(data);
			},
			success: function(data){
				$('#media_id').empty();
				$.each(data.media, function(i, item){
					$('#media_id').append('<option label="' + item.media_category_id + '" value="' + item.media_id + '">' + item.media_name + '</option>');
				});
				$('#media_id').selectpicker('refresh');

				$('#media_edition_id').empty();
				$.each(data.mediaedition, function(i, item){
					$('#media_edition_id').append('<option value="' + item.media_edition_id + '">' + item.media.media_name + ', ' + item.media_edition_no + ', Publish Date : ' + item.media_edition_publish_date + '</option>');
				});
				$('#media_edition_id').selectpicker('refresh');
			}
		})
	});
	
	var tmp_media_category = [];
	$('#media_id').change(function(){
		tmp_media_category = [];
		$.each($(this).find('option:selected'), function(i, item){
			tmp_media_category.push(item.label);
		});
		//console.log(tmp_media_category);

		if($.inArray("1", tmp_media_category) !== -1) {
			expandPrint();
		}else{
			collapsePrint();
		}

		if($.inArray("2", tmp_media_category) !== -1) {
			expandDigital();
		}else{
			collapseDigital();
		}		
	});


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

	function collapseAllField() {
		collapsePrint();
		collapseDigital();
	}

	function expandPrint() {
		$('#media_edition_id_container').show();
		$('#action_plan_pages_container').show();
	}

	function collapsePrint() {
		$('#media_edition_id_container').hide();
		$('#action_plan_pages_container').hide();
	}

	function expandDigital() {
		$('#action_plan_startdate_container').show();
		$('#action_plan_views_container').show();
	}

	function collapseDigital() {
		$('#action_plan_startdate_container').hide();
		$('#action_plan_views_container').hide();
	}
});