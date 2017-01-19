$(document).ready(function() {
    var myToken = $('meta[name="csrf-token"]').attr('content');

	$('#user_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/user/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    squery: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var users = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                users.push(
                    {
                        'value': curr.user_id,
                        'text': curr.user_firstname + ' ' + curr.user_lastname,
                        'disabled': false
                    }
                );
            }            
            return users;
        },
        preserveSelected: true
    });
});