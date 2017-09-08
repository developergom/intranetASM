//Need Checking
$("#grid-data-needchecking").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "workorder/proposal/apiList/needchecking",
    formatters: {
        "link-rua": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-edit"></span></a>';
            }else{
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Approve Proposal" href="' + base_url + 'workorder/proposal/action/' + row.flow_no + '/' + row.proposal_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-assignment-alert"></span></a>';
            }
        },
        "link-ru": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
            }else{
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>';
            }
        },
        "link-ra": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>';                
            }else{
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Approve Proposal" href="' + base_url + 'workorder/proposal/action/' + row.flow_no + '/' + row.proposal_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-assignment-alert"></span></a>';
            }
        },
        "link-r": function(column, row)
        {
            return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    },
    converters: {
        datetime: {
            from: function (value) { return moment(value); },
            to: function (value) { return moment(value).format("DD/MM/YYYY"); }
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    
});

//On Process
$("#grid-data-onprocess").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "workorder/proposal/apiList/onprocess",
    formatters: {
        "link-rd": function(column, row)
        {
            return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Proposal" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    },
    converters: {
        datetime: {
            from: function (value) { return moment(value); },
            to: function (value) { return moment(value).format("DD/MM/YYYY"); }
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    $("#grid-data-onprocess").find(".command-delete").on("click", function(e)
    {
        var delete_id = $(this).data('row-id');

        swal({
          title: "Are you sure want to delete this data?",
          text: "You will not be able to recover this action!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
          $.ajax({
            url: base_url + 'workorder/proposal/apiDelete',
            type: 'POST',
            data: {
                'inventory_planner_id' : delete_id,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function() {
                swal("Failed!", "Deleting data failed.", "error");
            },
            success: function(data) {
                if(data==100) 
                {
                    swal("Deleted!", "Your data has been deleted.", "success");
                    //$("#grid-data-onprocess").bootgrid("reload");
                    reload_datagrid();
                }else{
                    swal("Failed!", "Deleting data failed.", "error");
                }
            }
          });

          
        });
    });
});

//Finished
$("#grid-data-finished").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "workorder/proposal/apiList/finished",
    formatters: {
        "link-r": function(column, row)
        {
            if(uid==row.user_id) {
                var html = '';
                if(row.proposal_status_id==1) {
                    //sold
                    html = '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                        +'<a title="Create Summary" href="' + base_url + 'workorder/proposal/summary/' + row.proposal_id + '" class="btn btn-icon waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-assignment"></span></a>&nbsp;&nbsp;';
                }else if(row.proposal_status_id==2){
                    html = '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
                }else{
                    html = '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                        +'<a title="Update Status Proposal" href="' + base_url + 'workorder/proposal/update_status/' + row.proposal_id + '" class="btn btn-icon waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-alert-triangle"></span></a>&nbsp;&nbsp;';
                }
                

                return html;
            }else{
                return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
            }
        }
    },
    converters: {
        datetime: {
            from: function (value) { return moment(value); },
            to: function (value) { return moment(value).format("DD/MM/YYYY"); }
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    
});

//Canceled
$("#grid-data-canceled").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "workorder/proposal/apiList/canceled",
    formatters: {
        "link-r": function(column, row)
        {
            return '<a title="View Proposal" href="' + base_url + 'workorder/proposal/' + row.proposal_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.proposal_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    },
    converters: {
        datetime: {
            from: function (value) { return moment(value); },
            to: function (value) { return moment(value).format("DD/MM/YYYY"); }
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    
});


function reload_datagrid() {
    $("#grid-data-onprocess").bootgrid("reload");
    $("#grid-data-needchecking").bootgrid("reload");
    $("#grid-data-finished").bootgrid("reload");
    $("#grid-data-canceled").bootgrid("reload");
}