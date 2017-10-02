$(document).ready(function(){
    $('#mutation_from').change(function(){
        var mutation_from = $(this).val();

        $.ajax({
            url: base_url + '/config/mutation/api/loadTasks',
            type: 'POST',
            dataType: 'json',
            data: {
                    'mutation_from': mutation_from,
                    '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                var html = '';
                $.each(response.inventories_planner, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.inventory_planner_title + '</td>';
                    html += '<td></td>';
                    html += '</tr>';
                });

                $('#table-inventories tbody').empty().append(html);

                html = '';
                $.each(response.proposals, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.proposal_name + '</td>';
                    html += '<td></td>';
                    html += '</tr>';
                });

                $('#table-proposals tbody').empty().append(html);

                html = '';
                $.each(response.summaries, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.summary_order_no + '</td>';
                    html += '<td></td>';
                    html += '</tr>';
                });

                $('#table-summaries tbody').empty().append(html);

                $('#total-inventories').empty().append(response.inventories_planner.length);
                $('#total-proposals').empty().append(response.proposals.length);
                $('#total-summaries').empty().append(response.summaries.length);
            }
        });
    });
});