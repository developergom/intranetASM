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
		maxFilesize: 200,
		accept: function(file, done) {
			done();
		},
		error: function(file, response){
			console.log(response);
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
	$('#project_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/grid/project/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    project_name: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var projects = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                projects.push(
                    {
                        'value': curr.project_id,
                        'text': curr.project_name,
                        'disabled': false
                    }
                );
            }            
            return projects;
        },
        preserveSelected: true
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

	function generateDate(dateString) { //format dd/mm/yyyy
		return moment(dateString, "DD-MM-YYYY");
	}

	function diffDate(date1, date2) {
		return date2.diff(date1, 'days');
	}

	function convertNumber(value) { return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); }
});