$(document).ready(function(){
    $('#mutation_from').change(function(){
        var mutation_from = $(this).val();

        $('#table-inventories tbody').empty().append('Loading...');
        $('#table-proposals tbody').empty().append('Loading...');
        $('#table-contracts tbody').empty().append('Loading...');
        $('#table-summaries tbody').empty().append('Loading...');

        $.ajax({
            url: base_url + '/config/mutation/api/loadTasks',
            type: 'POST',
            dataType: 'json',
            data: {
                    'mutation_from': mutation_from,
                    '_token': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(response){
                $('#table-inventories tbody').empty().append('There is something problem with a connection...');
                $('#table-proposals tbody').empty().append('There is something problem with a connection...');
                $('#table-contracts tbody').empty().append('There is something problem with a connection...');
                $('#table-summaries tbody').empty().append('There is something problem with a connection...');
            },
            success: function(response){
                var html = '';
                $.each(response.inventories_planner, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.inventory_planner_title + '</td>';
                    html += '<td>';
                    html += '<input type="hidden" name="inventory_planner_id[]" value="' + value.inventory_planner_id + '">';
                    html += '<select name="inventory_assign_to[]" class="form-control">';
                    $.each(response.users, function(index, val){
                        html += '<option value="' + val.user_id + '">' + val.user_firstname + ' ' + val.user_lastname + ' - ' + val.user_name + '</option>';
                    });
                    html += '</select>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#table-inventories tbody').empty().append(html);

                html = '';
                $.each(response.proposals, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.proposal_name + '</td>';
                    html += '<td>';
                    html += '<input type="hidden" name="proposal_id[]" value="' + value.proposal_id + '">';
                    html += '<select name="proposal_assign_to[]" class="form-control">';
                    $.each(response.users, function(index, val){
                        html += '<option value="' + val.user_id + '">' + val.user_firstname + ' ' + val.user_lastname + ' - ' + val.user_name + '</option>';
                    });
                    html += '</select>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#table-proposals tbody').empty().append(html);

                html = '';
                $.each(response.contracts, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.contract_no + '</td>';
                    html += '<td>';
                    html += '<input type="hidden" name="contract_id[]" value="' + value.contract_id + '">';
                    html += '<select name="contract_assign_to[]" class="form-control">';
                    $.each(response.users, function(index, val){
                        html += '<option value="' + val.user_id + '">' + val.user_firstname + ' ' + val.user_lastname + ' - ' + val.user_name + '</option>';
                    });
                    html += '</select>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#table-contracts tbody').empty().append(html);

                html = '';
                $.each(response.summaries, function(key, value){
                    html += '<tr>';
                    html += '<td>' + value.summary_order_no + '</td>';
                    html += '<td>';
                    html += '<input type="hidden" name="summary_id[]" value="' + value.summary_id + '">';
                    html += '<select name="summary_assign_to[]" class="form-control">';
                    $.each(response.users, function(index, val){
                        html += '<option value="' + val.user_id + '">' + val.user_firstname + ' ' + val.user_lastname + ' - ' + val.user_name + '</option>';
                    });
                    html += '</select>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#table-summaries tbody').empty().append(html);

                $('#total-inventories').empty().append(response.inventories_planner.length);
                $('#total-proposals').empty().append(response.proposals.length);
                $('#total-contracts').empty().append(response.contracts.length);
                $('#total-summaries').empty().append(response.summaries.length);
            }
        });
    });
});