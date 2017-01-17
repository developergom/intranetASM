var basic_rate = 0;
var gross_rate = 0;
var surcharge = 0;
var total_gross_rate = 0;
var discount = 0;
var nett_rate = 0;

var total_nett_print = 0;
var total_nett_digital = 0;
var total_nett_event = 0;
var total_nett_creative = 0;
var total_nett_other = 0;
var total_nett = 0;
var total_value_print = 0;
var total_value_digital = 0;
var total_value_event = 0;
var total_value_creative = 0;
var total_value_other = 0;
var total_value = 0;
var saving_value = 0;

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

	//ajax bootstrap select
	$('#action_plan_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/plan/actionplan/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    action_plan_title: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
        	/*console.log(data);*/
            var actionplans = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                actionplans.push(
                    {
                        'value': curr.action_plan_id,
                        'text': curr.action_plan_title,
                        'disabled': false
                    }
                );
            }            
            return actionplans;
        },
        preserveSelected: true
    });

    //ajax bootstrap select
	$('#action_plan_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/plan/actionplan/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    action_plan_title: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
        	/*console.log(data);*/
            var actionplans = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                actionplans.push(
                    {
                        'value': curr.action_plan_id,
                        'text': curr.action_plan_title,
                        'disabled': false
                    }
                );
            }            
            return actionplans;
        },
        preserveSelected: true
    });

    //ajax bootstrap select
	$('#event_plan_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/plan/eventplan/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    event_plan_name: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
        	/*console.log(data);*/
            var eventplans = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                eventplans.push(
                    {
                        'value': curr.event_plan_id,
                        'text': curr.event_plan_name,
                        'disabled': false
                    }
                );
            }            
            return eventplans;
        },
        preserveSelected: true
    });

	//load all prices
	load_all_prices();

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

	$('body').on('click','.btn-delete-print-prices', function(){
		var key = $(this).data('key');

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			delete_print_price(key);
		});
	});

	$('body').on('click','.btn-delete-digital-prices', function(){
		var key = $(this).data('key');

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			delete_digital_price(key);
		});
	});

	$('body').on('click','.btn-delete-event-prices', function(){
		var key = $(this).data('key');

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			delete_event_price(key);
		});
	});

	$('body').on('click','.btn-delete-creative-prices', function(){
		var key = $(this).data('key');

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			delete_creative_price(key);
		});
	});

	$('body').on('click','.btn-delete-other-prices', function(){
		var key = $(this).data('key');

		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			delete_other_price(key);
		});
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
		$('#modal_add_inventory_planner_price_gross_rate_mask').val('');
		$('#modal_add_inventory_planner_price_total_gross_rate_mask').val('');
		$('#modal_add_inventory_planner_price_nett_rate_mask').val('');
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
		var media_id = $('#modal_add_media_id').val();
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
						$('#modal_add_inventory_planner_price_gross_rate_mask').val(convertNumber(basic_rate));
					}else if($('#modal_add_price_type_id').val() == '2') {
						//digital
						var modal_start_date = generateDate($('#modal_add_inventory_planner_price_startdate').val());
						var modal_end_date = generateDate($('#modal_add_inventory_planner_price_enddate').val());
						//var diff = 2;
						var diff = diffDate(modal_start_date, modal_end_date);
						$('#modal_add_inventory_planner_price_gross_rate').val(basic_rate * diff);
						$('#modal_add_inventory_planner_price_gross_rate_mask').val(convertNumber(basic_rate * diff));
					}else if($('#modal_add_price_type_id').val() == '4') {
						//creative
						$('#modal_add_inventory_planner_price_gross_rate').val(basic_rate);
						$('#modal_add_inventory_planner_price_gross_rate_mask').val(convertNumber(gross_rate));
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

		$('#modal_add_inventory_planner_price_gross_rate_mask').val(convertNumber(gross_rate));
		$('#modal_add_inventory_planner_price_total_gross_rate_mask').val(convertNumber(total_gross_rate));
		$('#modal_add_inventory_planner_price_nett_rate_mask').val(convertNumber(nett_rate));
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

				$.ajax({
					url: base_url + 'inventory/inventoryplanner/api/storePrintPrices',
					dataType: 'json',
					data: {
							price_type_id : $('#modal_add_price_type_id').val(),
					    	media_id : $('#modal_add_media_id').val(),
					    	media_name : $('#modal_add_media_id option:selected').text(),
					    	advertise_position_id : $('#modal_add_advertise_position_id').val(),
					    	advertise_position_name : $('#modal_add_advertise_position_id option:selected').text(),
					    	advertise_size_id : $('#modal_add_advertise_size_id').val(),
					    	advertise_size_name : $('#modal_add_advertise_size_id option:selected').text(),
					    	paper_id : $('#modal_add_paper_id').val(),
					    	paper_name : $('#modal_add_paper_id option:selected').text(),
					    	advertise_rate_id : $('#modal_add_advertise_rate_id').val(),
					    	advertise_rate_name : $('#modal_add_advertise_rate_id option:selected').text(),
					    	inventory_planner_print_price_gross_rate : $('#modal_add_inventory_planner_price_gross_rate').val(),
					    	inventory_planner_print_price_surcharge : $('#modal_add_inventory_planner_price_surcharge').val(),
					    	inventory_planner_print_price_total_gross_rate : $('#modal_add_inventory_planner_price_total_gross_rate').val(),
					    	inventory_planner_print_price_discount : $('#modal_add_inventory_planner_price_discount').val(),
					    	inventory_planner_print_price_nett_rate : $('#modal_add_inventory_planner_price_nett_rate').val(),
					    	inventory_planner_print_price_remarks : $('#modal_add_inventory_planner_price_remarks').val(),
							_token: myToken
						},
					type: 'POST',
					error: function(data) {
						swal("Failed!", "Adding data failed.", "error");
					},
					success: function(data) {
						if(data.status == '200') {
							swal("Success!", "Your package has been added.", "success");
							load_print_prices();
							$('.btn-close-inventory-planner-price').click();
						}else{
							swal("Failed!", "Adding data failed.", "error");
						}
					}
				});
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

				$.ajax({
					url: base_url + 'inventory/inventoryplanner/api/storeDigitalPrices',
					dataType: 'json',
					data: {
							price_type_id : $('#modal_add_price_type_id').val(),
					    	media_id : $('#modal_add_media_id').val(),
					    	media_name : $('#modal_add_media_id option:selected').text(),
					    	advertise_position_id : $('#modal_add_advertise_position_id').val(),
					    	advertise_position_name : $('#modal_add_advertise_position_id option:selected').text(),
					    	advertise_size_id : $('#modal_add_advertise_size_id').val(),
					    	advertise_size_name : $('#modal_add_advertise_size_id option:selected').text(),
					    	paper_id : $('#modal_add_paper_id').val(),
					    	paper_name : $('#modal_add_paper_id option:selected').text(),
					    	advertise_rate_id : $('#modal_add_advertise_rate_id').val(),
					    	advertise_rate_name : $('#modal_add_advertise_rate_id option:selected').text(),
					    	inventory_planner_digital_price_startdate : $('#modal_add_inventory_planner_price_startdate').val(),
					    	inventory_planner_digital_price_enddate : $('#modal_add_inventory_planner_price_enddate').val(),
					    	inventory_planner_digital_price_deadline : $('#modal_add_inventory_planner_price_deadline').val(),
					    	inventory_planner_digital_price_gross_rate : $('#modal_add_inventory_planner_price_gross_rate').val(),
					    	inventory_planner_digital_price_surcharge : $('#modal_add_inventory_planner_price_surcharge').val(),
					    	inventory_planner_digital_price_total_gross_rate : $('#modal_add_inventory_planner_price_total_gross_rate').val(),
					    	inventory_planner_digital_price_discount : $('#modal_add_inventory_planner_price_discount').val(),
					    	inventory_planner_digital_price_nett_rate : $('#modal_add_inventory_planner_price_nett_rate').val(),
					    	inventory_planner_digital_price_remarks : $('#modal_add_inventory_planner_price_remarks').val(),
							_token: myToken
						},
					type: 'POST',
					error: function(data) {
						swal("Failed!", "Adding data failed.", "error");
					},
					success: function(data) {
						if(data.status == '200') {
							swal("Success!", "Your package has been added.", "success");
							load_digital_prices();
							$('.btn-close-inventory-planner-price').click();
						}else{
							swal("Failed!", "Adding data failed.", "error");
						}
					}
				});
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

				$.ajax({
					url: base_url + 'inventory/inventoryplanner/api/storeEventPrices',
					dataType: 'json',
					data: {
							price_type_id : $('#modal_add_price_type_id').val(),
					    	media_id : $('#modal_add_media_id').val(),
					    	media_name : $('#modal_add_media_id option:selected').text(),
					    	inventory_planner_event_price_gross_rate : $('#modal_add_inventory_planner_price_gross_rate').val(),
					    	inventory_planner_event_price_surcharge : $('#modal_add_inventory_planner_price_surcharge').val(),
					    	inventory_planner_event_price_total_gross_rate : $('#modal_add_inventory_planner_price_total_gross_rate').val(),
					    	inventory_planner_event_price_discount : $('#modal_add_inventory_planner_price_discount').val(),
					    	inventory_planner_event_price_nett_rate : $('#modal_add_inventory_planner_price_nett_rate').val(),
					    	inventory_planner_event_price_remarks : $('#modal_add_inventory_planner_price_remarks').val(),
							_token: myToken
						},
					type: 'POST',
					error: function(data) {
						swal("Failed!", "Adding data failed.", "error");
					},
					success: function(data) {
						if(data.status == '200') {
							swal("Success!", "Your package has been added.", "success");
							load_event_prices();
							$('.btn-close-inventory-planner-price').click();
						}else{
							swal("Failed!", "Adding data failed.", "error");
						}
					}
				});
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

				$.ajax({
					url: base_url + 'inventory/inventoryplanner/api/storeCreativePrices',
					dataType: 'json',
					data: {
							price_type_id : $('#modal_add_price_type_id').val(),
					    	media_id : $('#modal_add_media_id').val(),
					    	media_name : $('#modal_add_media_id option:selected').text(),
					    	advertise_position_id : $('#modal_add_advertise_position_id').val(),
					    	advertise_position_name : $('#modal_add_advertise_position_id option:selected').text(),
					    	advertise_size_id : $('#modal_add_advertise_size_id').val(),
					    	advertise_size_name : $('#modal_add_advertise_size_id option:selected').text(),
					    	paper_id : $('#modal_add_paper_id').val(),
					    	paper_name : $('#modal_add_paper_id option:selected').text(),
					    	advertise_rate_id : $('#modal_add_advertise_rate_id').val(),
					    	advertise_rate_name : $('#modal_add_advertise_rate_id option:selected').text(),
					    	inventory_planner_creative_price_gross_rate : $('#modal_add_inventory_planner_price_gross_rate').val(),
					    	inventory_planner_creative_price_surcharge : $('#modal_add_inventory_planner_price_surcharge').val(),
					    	inventory_planner_creative_price_total_gross_rate : $('#modal_add_inventory_planner_price_total_gross_rate').val(),
					    	inventory_planner_creative_price_discount : $('#modal_add_inventory_planner_price_discount').val(),
					    	inventory_planner_creative_price_nett_rate : $('#modal_add_inventory_planner_price_nett_rate').val(),
					    	inventory_planner_creative_price_remarks : $('#modal_add_inventory_planner_price_remarks').val(),
							_token: myToken
						},
					type: 'POST',
					error: function(data) {
						swal("Failed!", "Adding data failed.", "error");
					},
					success: function(data) {
						if(data.status == '200') {
							swal("Success!", "Your package has been added.", "success");
							load_creative_prices();
							$('.btn-close-inventory-planner-price').click();
						}else{
							swal("Failed!", "Adding data failed.", "error");
						}
					}
				});
			}
		}else if($('#modal_add_price_type_id').val() == '5') {
			//other
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

				$.ajax({
					url: base_url + 'inventory/inventoryplanner/api/storeOtherPrices',
					dataType: 'json',
					data: {
							price_type_id : $('#modal_add_price_type_id').val(),
					    	media_id : $('#modal_add_media_id').val(),
					    	media_name : $('#modal_add_media_id option:selected').text(),
					    	inventory_planner_other_price_gross_rate : $('#modal_add_inventory_planner_price_gross_rate').val(),
					    	inventory_planner_other_price_surcharge : $('#modal_add_inventory_planner_price_surcharge').val(),
					    	inventory_planner_other_price_total_gross_rate : $('#modal_add_inventory_planner_price_total_gross_rate').val(),
					    	inventory_planner_other_price_discount : $('#modal_add_inventory_planner_price_discount').val(),
					    	inventory_planner_other_price_nett_rate : $('#modal_add_inventory_planner_price_nett_rate').val(),
					    	inventory_planner_other_price_remarks : $('#modal_add_inventory_planner_price_remarks').val(),
							_token: myToken
						},
					type: 'POST',
					error: function(data) {
						swal("Failed!", "Adding data failed.", "error");
					},
					success: function(data) {
						if(data.status == '200') {
							swal("Success!", "Your package has been added.", "success");
							load_other_prices();
							$('.btn-close-inventory-planner-price').click();
						}else{
							swal("Failed!", "Adding data failed.", "error");
						}
					}
				});
			}
		}else{
			
		}
	}

	function delete_print_price(key) {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/deletePrintPrices',
			dataType: 'json',
			data: {
					key : key,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				swal("Failed!", "Deleting data failed.", "error");
			},
			success: function(data) {
				if(data.status == '200') {
					swal("Success!", "Your data has been deleted.", "success");
					load_print_prices();
				}else{
					swal("Failed!", "Deleting data failed.", "error");
				}
			}
		});
	}

	function delete_digital_price(key) {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/deleteDigitalPrices',
			dataType: 'json',
			data: {
					key : key,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				swal("Failed!", "Deleting data failed.", "error");
			},
			success: function(data) {
				if(data.status == '200') {
					swal("Success!", "Your data has been deleted.", "success");
					load_digital_prices();
				}else{
					swal("Failed!", "Deleting data failed.", "error");
				}
			}
		});
	}

	function delete_event_price(key) {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/deleteEventPrices',
			dataType: 'json',
			data: {
					key : key,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				swal("Failed!", "Deleting data failed.", "error");
			},
			success: function(data) {
				if(data.status == '200') {
					swal("Success!", "Your data has been deleted.", "success");
					load_event_prices();
				}else{
					swal("Failed!", "Deleting data failed.", "error");
				}
			}
		});
	}

	function delete_creative_price(key) {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/deleteCreativePrices',
			dataType: 'json',
			data: {
					key : key,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				swal("Failed!", "Deleting data failed.", "error");
			},
			success: function(data) {
				if(data.status == '200') {
					swal("Success!", "Your data has been deleted.", "success");
					load_creative_prices();
				}else{
					swal("Failed!", "Deleting data failed.", "error");
				}
			}
		});
	}

	function delete_other_price(key) {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/deleteOtherPrices',
			dataType: 'json',
			data: {
					key : key,
					_token: myToken
				},
			type: 'POST',
			error: function(data) {
				swal("Failed!", "Deleting data failed.", "error");
			},
			success: function(data) {
				if(data.status == '200') {
					swal("Success!", "Your data has been deleted.", "success");
					load_other_prices();
				}else{
					swal("Failed!", "Deleting data failed.", "error");
				}
			}
		});
	}

	function load_all_prices() {
		load_print_prices();
		load_digital_prices();
		load_event_prices();
		load_creative_prices();
		load_other_prices();

		calculateTotal();
	}

	function load_print_prices() {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/loadPrintPrices',
			dataType: 'json',
			type: 'GET',
			error: function(data) {
				alert('error');
			},
			success: function(data) {
				var html = '';
				total_value_print = 0;
				total_nett_print = 0;
				$.each(data.prices, function(key, value) {
					console.log(value);
					html += '<tr>';
					html += '<td>' + value.media_name + '</td>';
					html += '<td>' + value.advertise_position_name + '</td>';
					html += '<td>' + value.advertise_size_name + '</td>';
					html += '<td>' + value.paper_name + '</td>';
					html += '<td>' + value.advertise_rate_name + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_surcharge) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_total_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_discount) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_nett_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_print_price_remarks) + '</td>';
					html += '<td><a title="Delete Price" href="javascript:void(0);" class="btn btn-icon btn-delete-print-prices waves-effect waves-circle" type="button" data-key="' + key + '"><span class="zmdi zmdi-delete"></span></a></td>';
					html += '</tr>';
					total_value_print = Number(total_value_print) + Number(value.inventory_planner_print_price_total_gross_rate);
					total_nett_print = Number(total_nett_print) + Number(value.inventory_planner_print_price_nett_rate);
				});

				$('#grid-data-listprint tbody').empty();
				$('#grid-data-listprint tbody').append(html);

				calculateTotal();
			}
		});
	}

	function load_digital_prices() {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/loadDigitalPrices',
			dataType: 'json',
			type: 'GET',
			error: function(data) {
				alert('error');
			},
			success: function(data) {
				var html = '';
				total_value_digital = 0;
				total_nett_digital = 0;
				$.each(data.prices, function(key, value) {
					console.log(value);
					html += '<tr>';
					html += '<td>' + value.media_name + '</td>';
					html += '<td>' + value.advertise_position_name + '</td>';
					html += '<td>' + value.advertise_size_name + '</td>';
					html += '<td>' + value.paper_name + '</td>';
					html += '<td>' + value.advertise_rate_name + '</td>';
					html += '<td>' + value.inventory_planner_digital_price_startdate + '</td>';
					html += '<td>' + value.inventory_planner_digital_price_enddate + '</td>';
					html += '<td>' + value.inventory_planner_digital_price_deadline + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_surcharge) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_total_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_discount) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_nett_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_digital_price_remarks) + '</td>';
					html += '<td><a title="Delete Price" href="javascript:void(0);" class="btn btn-icon btn-delete-digital-prices waves-effect waves-circle" type="button" data-key="' + key + '"><span class="zmdi zmdi-delete"></span></a></td>';
					html += '</tr>';
					total_value_digital = Number(total_value_digital) + Number(value.inventory_planner_digital_price_total_gross_rate);
					total_nett_digital = Number(total_nett_digital) + Number(value.inventory_planner_digital_price_nett_rate);
				});

				$('#grid-data-listdigital tbody').empty();
				$('#grid-data-listdigital tbody').append(html);

				calculateTotal();
			}
		});
	}

	function load_event_prices() {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/loadEventPrices',
			dataType: 'json',
			type: 'GET',
			error: function(data) {
				alert('error');
			},
			success: function(data) {
				var html = '';
				total_value_event = 0;
				total_nett_event = 0;
				$.each(data.prices, function(key, value) {
					console.log(value);
					html += '<tr>';
					html += '<td>' + value.media_name + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_surcharge) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_total_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_discount) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_nett_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_event_price_remarks) + '</td>';
					html += '<td><a title="Delete Price" href="javascript:void(0);" class="btn btn-icon btn-delete-event-prices waves-effect waves-circle" type="button" data-key="' + key + '"><span class="zmdi zmdi-delete"></span></a></td>';
					html += '</tr>';
					total_value_event = Number(total_value_event) + Number(value.inventory_planner_event_price_total_gross_rate);
					total_nett_event = Number(total_nett_event) + Number(value.inventory_planner_event_price_nett_rate);
				});

				$('#grid-data-listevent tbody').empty();
				$('#grid-data-listevent tbody').append(html);

				calculateTotal();
			}
		});
	}

	function load_creative_prices() {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/loadCreativePrices',
			dataType: 'json',
			type: 'GET',
			error: function(data) {
				alert('error');
			},
			success: function(data) {
				var html = '';
				total_value_creative = 0;
				total_nett_creative = 0;
				$.each(data.prices, function(key, value) {
					console.log(value);
					html += '<tr>';
					html += '<td>' + value.media_name + '</td>';
					html += '<td>' + value.advertise_position_name + '</td>';
					html += '<td>' + value.advertise_size_name + '</td>';
					html += '<td>' + value.paper_name + '</td>';
					html += '<td>' + value.advertise_rate_name + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_surcharge) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_total_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_discount) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_nett_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_creative_price_remarks) + '</td>';
					html += '<td><a title="Delete Price" href="javascript:void(0);" class="btn btn-icon btn-delete-creative-prices waves-effect waves-circle" type="button" data-key="' + key + '"><span class="zmdi zmdi-delete"></span></a></td>';
					html += '</tr>';
					total_value_creative = Number(total_value_creative) + Number(value.inventory_planner_creative_price_total_gross_rate);
					total_nett_creative = Number(total_nett_creative) + Number(value.inventory_planner_creative_price_nett_rate);
				});

				$('#grid-data-listcreative tbody').empty();
				$('#grid-data-listcreative tbody').append(html);

				calculateTotal();
			}
		});
	}

	function load_other_prices() {
		$.ajax({
			url: base_url + 'inventory/inventoryplanner/api/loadOtherPrices',
			dataType: 'json',
			type: 'GET',
			error: function(data) {
				alert('error');
			},
			success: function(data) {
				var html = '';
				total_value_other = 0;
				total_nett_other = 0;
				$.each(data.prices, function(key, value) {
					console.log(value);
					html += '<tr>';
					html += '<td>' + value.media_name + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_surcharge) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_total_gross_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_discount) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_nett_rate) + '</td>';
					html += '<td>' + convertNumber(value.inventory_planner_other_price_remarks) + '</td>';
					html += '<td><a title="Delete Price" href="javascript:void(0);" class="btn btn-icon btn-delete-other-prices waves-effect waves-circle" type="button" data-key="' + key + '"><span class="zmdi zmdi-delete"></span></a></td>';
					html += '</tr>';
					total_value_other = Number(total_value_other) + Number(value.inventory_planner_other_price_total_gross_rate);
					total_nett_other = Number(total_nett_other) + Number(value.inventory_planner_other_price_nett_rate);
				});

				$('#grid-data-listother tbody').empty();
				$('#grid-data-listother tbody').append(html);

				calculateTotal();
			}
		});
	}

	function calculateTotal() {
		total_nett = total_nett_print + total_nett_digital + total_nett_event + total_nett_creative + total_nett_other;
		total_value = total_value_print + total_value_digital + total_value_event + total_value_creative + total_value_other;
		saving_value = total_value - total_nett;

		$('#total_value').val(convertNumber(total_value));
		$('#total_nett').val(convertNumber(total_nett));
		$('#saving_value').val(convertNumber(saving_value));
	}

	function convertNumber(value) { return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); }
});