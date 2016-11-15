var basic_rate = 0;
var gross_rate = 0;
var surcharge = 0;
var total_gross_rate = 0;
var discount = 0;
var nett_rate = 0;

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
		$('#modal_add_price_type_id').val('');
		$('#modal_add_price_type_id').selectpicker('refresh');
		$('#modalAddInventoryPlannerPrice').modal();
	});

	$('#modal_add_price_type_id').change(function(){
		clearModalAdd();
		enabledModalAdd();
		getRates();

		if($(this).val() == '1') {
			//print
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_total_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_nett_rate').attr('disabled', true);
		}else if($(this).val() == '2') {
			//digital
			$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_total_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_nett_rate').attr('disabled', true);
		}else if($(this).val() == '3') {
			//event
			$('#modal_add_advertise_position_id').attr('disabled', true);
			$('#modal_add_advertise_size_id').attr('disabled', true);
			$('#modal_add_paper_id').attr('disabled', true);
			$('#modal_add_advertise_rate_id').attr('disabled', true);
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_total_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_nett_rate').attr('disabled', true);
		}else if($(this).val() == '4') {
			//creative
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_total_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_nett_rate').attr('disabled', true);
		}else if($(this).val() == '5') {
			//other
			$('#modal_add_advertise_position_id').attr('disabled', true);
			$('#modal_add_advertise_size_id').attr('disabled', true);
			$('#modal_add_paper_id').attr('disabled', true);
			$('#modal_add_advertise_rate_id').attr('disabled', true);
			$('#modal_add_inventory_planner_price_startdate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_enddate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_deadline').attr('disabled', true);
			$('#modal_add_inventory_planner_price_total_gross_rate').attr('disabled', true);
			$('#modal_add_inventory_planner_price_nett_rate').attr('disabled', true);
		}else{
			enabledModalAdd();
		}
	});

	$('#modal_add_advertise_position_id, #modal_add_advertise_size_id, #modal_add_media_id, #modal_add_paper_id').change(function() {
		getRates();
	});

	$('#modal_add_advertise_rate_id, #modal_add_inventory_planner_price_startdate, #modal_add_inventory_planner_price_enddate, #modal_add_inventory_planner_price_gross_rate, #modal_add_inventory_planner_price_discount, #modal_add_inventory_planner_price_surcharge'). change(function() {
		getBasicRate($('#modal_add_advertise_rate_id').val());
	});

	$('.btn-add-inventory-planner-price').click(function() {
		save_price();
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
		resetRate();
		$('#modal_add_inventory_planner_price_remarks').val('');
	}

	function resetRate() {
		basic_rate = 0;
		gross_rate = 0;
		surcharge = 0;
		total_gross_rate = 0;
		discount = 0;
		nett_rate = 0;

		$('#modal_add_inventory_planner_price_gross_rate').val(gross_rate);
		$('#modal_add_inventory_planner_price_surcharge').val(surcharge);
		$('#modal_add_inventory_planner_price_total_gross_rate').val(total_gross_rate);
		$('#modal_add_inventory_planner_price_discount').val(discount);
		$('#modal_add_inventory_planner_price_nett_rate').val(nett_rate);
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
					advertise_size_id: advertise_size_id,
					paper_id: paper_id,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				console.log(data);
			},
			success: function(data) {
				$.each(data.rates, function(key, value){
					$('#modal_add_advertise_rate_id').append('<option value="' + value.advertise_rate_id + '">' + value.advertise_rate_code + ' - ' + value.advertise_rate_normal + '</option>');
				});

				$('#modal_add_advertise_rate_id').selectpicker('refresh');

				resetRate();
				getBasicRate($('#modal_add_advertise_rate_id').val());
				calculateRate();
			}
		});
	}

	function getBasicRate(advertise_rate_id) {
		if(($('#modal_add_price_type_id').val() == '1') || ($('#modal_add_price_type_id').val() == '2') || ($('#modal_add_price_type_id').val() == '4')){
			$.ajax({
				url: base_url + 'inventory/inventoryplanner/api/getBasicRate',
				dataType: 'json',
				data: {
						advertise_rate_id: advertise_rate_id,
						_token: myToken
					},
				type: 'POST',
				error: function(data) {
					$('#modal_add_inventory_planner_price_gross_rate').val(0);
				},
				success: function(data) {
					basic_rate = data.basic_rate;
					
					if($('#modal_add_price_type_id').val() == '1') {
						//print
						$('#modal_add_inventory_planner_price_gross_rate').val(basic_rate);
					}else if($('#modal_add_price_type_id').val() == '2') {
						//digital
						var modal_start_date = generateDate($('#modal_add_inventory_planner_price_startdate').val());
						var modal_end_date = generateDate($('#modal_add_inventory_planner_price_enddate').val());
						//var diff = 2;
						var diff = diffDate(modal_start_date, modal_end_date);
						$('#modal_add_inventory_planner_price_gross_rate').val(basic_rate * diff);
					}else if($('#modal_add_price_type_id').val() == '4') {
						//creative
						$('#modal_add_inventory_planner_price_gross_rate').val(basic_rate);
					}

					calculateRate();
				}
			});
		}else{

			calculateRate();
		}
	}

	function calculateRate() {
		gross_rate = Number($('#modal_add_inventory_planner_price_gross_rate').val());
		surcharge = Number($('#modal_add_inventory_planner_price_surcharge').val());
		total_gross_rate = gross_rate + (gross_rate * (surcharge / 100));
		discount = Number($('#modal_add_inventory_planner_price_discount').val());
		nett_rate = total_gross_rate - (total_gross_rate * (discount / 100));

		$('#modal_add_inventory_planner_price_surcharge').val(surcharge);
		$('#modal_add_inventory_planner_price_total_gross_rate').val(total_gross_rate);
		$('#modal_add_inventory_planner_price_discount').val(discount);
		$('#modal_add_inventory_planner_price_nett_rate').val(nett_rate);
	}

	function generateDate(dateString) { //format dd/mm/yyyy
		return moment(dateString, "DD-MM-YYYY");
	}

	function diffDate(date1, date2) {
		return date2.diff(date1, 'days');
	}

	function save_price() {
		var isValid = false;
		if($('#modal_add_price_type_id').val() == '1') {
			//print
			if($('#modal_add_media_id').val() == '') {
				$('#modal_add_media_id').parents('.form-group').addClass('has-error').find('.help-block').html('Media Must Be Choosen.');
		        $('#modal_add_media_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_position_id').val() == '') {
				$('#modal_add_advertise_position_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Position Must Be Choosen.');
		        $('#modal_add_advertise_position_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_size_id').val() == '') {
				$('#modal_add_advertise_size_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Size Must Be Choosen.');
		        $('#modal_add_advertise_size_id').focus();
		        isValid = false;
			}else if($('#modal_add_paper_id').val() == '') {
				$('#modal_add_paper_id').parents('.form-group').addClass('has-error').find('.help-block').html('Paper Must Be Choosen.');
		        $('#modal_add_paper_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_rate_id').val() == '') {
				$('#modal_add_advertise_rate_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Rate Must Be Choosen.');
		        $('#modal_add_advertise_rate_id').focus();
		        isValid = false;
			}else{
				$('#modal_add_media_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_position_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_size_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_paper_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_rate_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				isValid = true;

				alert('Recording..');
			}
			
		}else if($('#modal_add_price_type_id').val() == '2') {
			//digital
			if($('#modal_add_media_id').val() == '') {
				$('#modal_add_media_id').parents('.form-group').addClass('has-error').find('.help-block').html('Media Must Be Choosen.');
		        $('#modal_add_media_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_position_id').val() == '') {
				$('#modal_add_advertise_position_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Position Must Be Choosen.');
		        $('#modal_add_advertise_position_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_size_id').val() == '') {
				$('#modal_add_advertise_size_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Size Must Be Choosen.');
		        $('#modal_add_advertise_size_id').focus();
		        isValid = false;
			}else if($('#modal_add_paper_id').val() == '') {
				$('#modal_add_paper_id').parents('.form-group').addClass('has-error').find('.help-block').html('Paper Must Be Choosen.');
		        $('#modal_add_paper_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_rate_id').val() == '') {
				$('#modal_add_advertise_rate_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Rate Must Be Choosen.');
		        $('#modal_add_advertise_rate_id').focus();
		        isValid = false;
			}else if($('#modal_add_inventory_planner_price_startdate').val() == '') {
				$('#modal_add_inventory_planner_price_startdate').parents('.form-group').addClass('has-error').find('.help-block').html('Start Date Must Be Filled.');
		        $('#modal_add_inventory_planner_price_startdate').focus();
		        isValid = false;
			}else if($('#modal_add_inventory_planner_price_enddate').val() == '') {
				$('#modal_add_inventory_planner_price_enddate').parents('.form-group').addClass('has-error').find('.help-block').html('End Date Must Be Filled.');
		        $('#modal_add_inventory_planner_price_enddate').focus();
		        isValid = false;
			}else if($('#modal_add_inventory_planner_price_deadline').val() == '') {
				$('#modal_add_inventory_planner_price_deadline').parents('.form-group').addClass('has-error').find('.help-block').html('Deadline Must Be Filled.');
		        $('#modal_add_inventory_planner_price_deadline').focus();
		        isValid = false;
			}else{
				$('#modal_add_media_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_position_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_size_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_paper_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_rate_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_inventory_planner_price_startdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_inventory_planner_price_enddate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_inventory_planner_price_deadline').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				isValid = true;

				alert('Recording..');
			}
		}else if($('#modal_add_price_type_id').val() == '3') {
			//event
			if($('#modal_add_media_id').val() == '') {
				$('#modal_add_media_id').parents('.form-group').addClass('has-error').find('.help-block').html('Media Must Be Choosen.');
		        $('#modal_add_media_id').focus();
		        isValid = false;
			}else if($('#modal_add_inventory_planner_price_gross_rate').val() == '') {
				$('#modal_add_inventory_planner_price_gross_rate').parents('.form-group').addClass('has-error').find('.help-block').html('Gross Rate Must Be Filled.');
		        $('#modal_add_inventory_planner_price_gross_rate').focus();
		        isValid = false;
			}else{
				$('#modal_add_media_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_position_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_size_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_paper_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_rate_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				isValid = true;

				alert('Recording..');
			}
		}else if($('#modal_add_price_type_id').val() == '4') {
			//creative
			if($('#modal_add_media_id').val() == '') {
				$('#modal_add_media_id').parents('.form-group').addClass('has-error').find('.help-block').html('Media Must Be Choosen.');
		        $('#modal_add_media_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_position_id').val() == '') {
				$('#modal_add_advertise_position_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Position Must Be Choosen.');
		        $('#modal_add_advertise_position_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_size_id').val() == '') {
				$('#modal_add_advertise_size_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Size Must Be Choosen.');
		        $('#modal_add_advertise_size_id').focus();
		        isValid = false;
			}else if($('#modal_add_paper_id').val() == '') {
				$('#modal_add_paper_id').parents('.form-group').addClass('has-error').find('.help-block').html('Paper Must Be Choosen.');
		        $('#modal_add_paper_id').focus();
		        isValid = false;
			}else if($('#modal_add_advertise_rate_id').val() == '') {
				$('#modal_add_advertise_rate_id').parents('.form-group').addClass('has-error').find('.help-block').html('Advertise Rate Must Be Choosen.');
		        $('#modal_add_advertise_rate_id').focus();
		        isValid = false;
			}else{
				$('#modal_add_media_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_position_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_size_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_paper_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				$('#modal_add_advertise_rate_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
				isValid = true;

				alert('Recording..');
			}
		}else if($('#modal_add_price_type_id').val() == '5') {
			//other
			
		}else{
			
		}
	}
});