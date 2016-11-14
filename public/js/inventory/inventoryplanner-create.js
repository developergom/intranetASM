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


	//modal
	$(".command-add-inventory-planner-price").click(function(){
		clearModalAdd();
		copyMedia();
		enabledModalAdd();
		$('#modalAddInventoryPlannerPrice').modal();
	});

	$('#modal_add_price_type_id').change(function(){
		enabledModalAdd();

		if($(this).val() == '1') {
			//print
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', true);
		}else if($(this).val() == '2') {
			//digital

		}else if($(this).val() == '3') {
			//event
			$('#modal_add_advertise_position_id').attr('disabled', true);
			$('#modal_add_advertise_size_id').attr('disabled', true);
			$('#modal_add_paper_id').attr('disabled', true);
			$('#modal_add_advertise_rate_id').attr('disabled', true);
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
		}else if($(this).val() == '4') {
			//creative
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', true);
		}else if($(this).val() == '5') {
			//other
			$('#modal_add_advertise_position_id').attr('disabled', true);
			$('#modal_add_advertise_size_id').attr('disabled', true);
			$('#modal_add_paper_id').attr('disabled', true);
			$('#modal_add_advertise_rate_id').attr('disabled', true);
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
		}else{
			enabledModalAdd();
		}
	});

	$('#modal_add_advertise_position_id, #modal_add_advertise_size_id, #modal_add_media_id, #modal_add_paper_id').change(function() {
		getRates();
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

	function clearModalAdd() {
		$('#modal_add_price_type_id').val('');
		$('#modal_add_price_type_id').selectpicker('refresh');
		$('#modal_add_media_id').val('');
		$('#modal_add_media_id').selectpicker('refresh');
		/*$('#modal_add_media_edition_id').val('');
		$('#modal_add_media_edition_id').selectpicker('refresh');*/
		$('#modal_add_advertise_position_id').val('');
		$('#modal_add_advertise_position_id').selectpicker('refresh');
		$('#modal_add_advertise_size_id').val('');
		$('#modal_add_advertise_size_id').selectpicker('refresh');
		$('#modal_add_paper_id').val('');
		$('#modal_add_paper_id').selectpicker('refresh');
		$('#modal_add_advertise_rate_id').val('');
		$('#modal_add_advertise_rate_id').selectpicker('refresh');
		$('#modal_add_inventory_planner_price_startdate').val('');
		$('#modal_add_inventory_planner_price_enddate').val('');
		$('#modal_add_inventory_planner_price_deadline').val('');
		$('#modal_add_inventory_planner_price_gross_rate').val('');
		$('#modal_add_inventory_planner_price_surcharge').val('');
		$('#modal_add_inventory_planner_price_total_gross_rate').val('');
		$('#modal_add_inventory_planner_price_discount').val('');
		$('#modal_add_inventory_planner_price_nett_rate').val('');
		$('#modal_add_inventory_planner_price_remarks').val('');
	}

	function enabledModalAdd() {
		$('#modal_add_media_id').attr('disabled', false);
		$('#modal_add_advertise_position_id').attr('disabled', false);
		$('#modal_add_advertise_size_id').attr('disabled', false);
		$('#modal_add_paper_id').attr('disabled', false);
		$('#modal_add_advertise_rate_id').attr('disabled', false);
		$('#modal_add_inventory_planner_price_startdate').attr('disabled', false);
		$('#modal_add_inventory_planner_price_enddate').attr('disabled', false);
		$('#modal_add_inventory_planner_price_deadline').attr('disabled', false);
		$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', false);
	}


	function copyMedia() {
		var media = $('#media_id').val();

		/*//console.log(media);
		$.each(media, function(key, value){
			console.log(value);
		});*/
		
		$('#modal_add_media_id').empty();

		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/getMedias',
			dataType: 'json',
			data: {
					medias: media,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				console.log(data);
			},
			success: function(data) {
				$.each(data.media, function(key, value){
					$('#modal_add_media_id').append('<option value="' + value.media_id + '">' + value.media_name + '</option>');
				});

				$('#modal_add_media_id').selectpicker('refresh');
			}
		});
	}

	function getRates() {
		var media_id = $('#media_id').val();
		var advertise_position_id = $('#modal_add_advertise_position_id').val();
		var advertise_size_id = $('#modal_add_advertise_size_id').val();
		var paper_id = $('#modal_add_paper_id').val();

		$('#modal_add_advertise_rate_id').empty();

		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/getRates',
			dataType: 'json',
			data: {
					media_id: media_id,
					advertise_position_id: advertise_position_id,
					modal_add_advertise_size_id: advertise_size_id,
					paper_id: paper_id,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				console.log(data);
			},
			success: function(data) {
				console.log(data);

				$.each(data.rates, function(key, value){
					$('#modal_add_advertise_rate_id').append('<option value="' + value.advertise_rate_id + '">' + value.advertise_rate_code + ' - ' + value.advertise_rate_normal + '</option>');
				});

				$('#modal_add_advertise_rate_id').selectpicker('refresh');
			}
		});
	}
});