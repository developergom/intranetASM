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

	$('#client_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + 'master/client/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    clientName: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var clients = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                clients.push(
                    {
                        'value': curr.client_id,
                        'text': curr.client_name,
                        'disabled': false
                    }
                );
            }            
            return clients;
        },
        preserveSelected: true
    });

});