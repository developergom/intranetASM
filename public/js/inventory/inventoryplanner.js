var medias = [];
var categories = [];
var implementations = [];
var years = [];

//Need Checking
$('#need_checking_media_id,#need_checking_inventory_inventory_category_id,#need_checking_implementation_id,#need_checking_year').change(function(){
    medias = $('#need_checking_media_id').val();
    categories = $('#need_checking_inventory_inventory_category_id').val();
    implementations = $('#need_checking_implementation_id').val();
    years = $('#need_checking_year').val();

    $("#grid-data-needchecking").bootgrid("reload");
});
$("#grid-data-needchecking").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'medias': medias,
            'categories': categories,
            'implementations': implementations,
            'years': years
        };
    },
    url: base_url + "inventory/inventoryplanner/apiList/needchecking",
    formatters: {
        "link-rua": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-edit"></span></a>';
            }else{
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Approve Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/approve/' + row.flow_no + '/' + row.inventory_planner_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-assignment-alert"></span></a>';
            }
        },
        "link-ru": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
            }else{
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>';
            }
        },
        "link-ra": function(column, row)
        {
            if(row.flow_no=='1') {
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>';                
            }else{
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Approve Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/approve/' + row.flow_no + '/' + row.inventory_planner_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-assignment-alert"></span></a>';
            }
        },
        "link-r": function(column, row)
        {
            return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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
$('#on_process_media_id,#on_process_inventory_category_id,#on_process_implementation_id,#on_process_year').change(function(){
    medias = $('#on_process_media_id').val();
    categories = $('#on_process_inventory_category_id').val();
    implementations = $('#on_process_implementation_id').val();
    years = $('#on_process_year').val();

    $("#grid-data-onprocess").bootgrid("reload");
});
$("#grid-data-onprocess").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'medias': medias,
            'categories': categories,
            'implementations': implementations,
            'years': years
        };
    },
    url: base_url + "inventory/inventoryplanner/apiList/onprocess",
    formatters: {
        "link-rd": function(column, row)
        {
            return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Inventory Planner" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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
            url: base_url + 'inventory/inventoryplanner/apiDelete',
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
$('#finished_media_id,#finished_inventory_category_id,#finished_implementation_id,#finished_year').change(function(){
    medias = $('#finished_media_id').val();
    categories = $('#finished_inventory_category_id').val();
    implementations = $('#finished_implementation_id').val();
    years = $('#finished_year').val();

    $("#grid-data-finished").bootgrid("reload");
});
$("#grid-data-finished").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'medias': medias,
            'categories': categories,
            'implementations': implementations,
            'years': years
        };
    },
    url: base_url + "inventory/inventoryplanner/apiList/finished",
    formatters: {
        "link-r": function(column, row)
        {
            if(uid==row.user_id) {
                return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                +'<a title="Edit Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/renew/' + row.inventory_planner_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
            }else{
                if(cancreateproposal==true) 
                {
                    return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                            +'<a title="Create to Direct Proposal" href="' + base_url + 'workorder/proposal/create_direct/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-mail-send"></span></a>&nbsp;&nbsp;';
                }else{
                    return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
                }
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
$('#canceled_media_id,#canceled_inventory_category_id,#canceled_implementation_id,#canceled_year').change(function(){
    medias = $('#canceled_media_id').val();
    categories = $('#canceled_inventory_category_id').val();
    implementations = $('#canceled_implementation_id').val();
    years = $('#canceled_year').val();

    $("#grid-data-canceled").bootgrid("reload");
});
$("#grid-data-canceled").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'medias': medias,
            'categories': categories,
            'implementations': implementations,
            'years': years
        };
    },
    url: base_url + "inventory/inventoryplanner/apiList/canceled",
    formatters: {
        "link-r": function(column, row)
        {
            return '<a title="View Inventory Planner" href="' + base_url + 'inventory/inventoryplanner/' + row.inventory_planner_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.inventory_planner_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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