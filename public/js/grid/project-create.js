$(document).ready(function(){
	var myToken = $('meta[name="csrf-token"]').attr('content');

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