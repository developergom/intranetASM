var myToken = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function(){
    $('#contract_id')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: base_url + '/workorder/contract/apiSearch',
            data: function () {
                var params = {
                	_token: myToken,
                    keyword: '{{{q}}}'
                };
                return params;
            }
        },
        locale: {
            emptyTitle: 'NOTHING SELECTED'
        },
        preprocessData: function(data){
            var contracts = [];
            var len = data.length;
            for(var i = 0; i < len; i++){
                var curr = data[i];
                contracts.push(
                    {
                        'value': curr.contract_id,
                        'text': curr.contract_no + ' - ' + curr.proposal_name,
                        'disabled': false
                    }
                );
            }            
            return contracts;
        },
        preserveSelected: true
    });
});