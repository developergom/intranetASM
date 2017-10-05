var agendaauthors = $('#my-agenda-select-author').val();
var agendaclientname = 'all';
$('#my-agenda').monthly({
    'mode' : 'event',
    'stylePast' : true,
    'dataType' : 'json',
    'jsonUrl' : base_url + 'agenda/plan/api/loadMyAgenda/' + agendaauthors + '/' + agendaclientname,
});

$('#my-agenda-client-id')
.selectpicker({
    liveSearch: true
})
.ajaxSelectPicker({
    ajax: {
        url: base_url + '/master/client/apiSearch',
        data: function () {
            var params = {
                _token: $('meta[name="csrf-token"]').attr('content'),
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

$('#btn-my-agenda-process').click(function() {
    agendaauthors = $('#my-agenda-select-author').val();
    agendaclientid = $('#my-agenda-client-id').val();

    if(agendaauthors == null) {
        agendaauthors = 'all';
    }

    if(agendaclientid == null) {
        agendaclientid = 'all';
    }

    newid= new Date().getTime();

    $('.monthly-agenda-calendar').empty().replaceWith('<div class="monthly monthly-agenda-calendar" id="macal' + newid + '"></div>');

    $('#macal' + newid).monthly({
        'mode' : 'event',
        'stylePast' : true,
        'dataType' : 'json',
        'jsonUrl' : base_url + 'agenda/plan/api/loadMyAgenda/' + agendaauthors + '/' + agendaclientid,
    });
});