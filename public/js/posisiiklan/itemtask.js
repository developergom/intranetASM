//Available
$("#grid-data-available").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "posisi-iklan/item_task/apiList/available",
    formatters: {
        "link-rua": function(column, row)
        {
            return '<a title="Take this task" href="' + base_url + 'posisi-iklan/item_task/take/' + row.summary_item_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.summary_item_id + '"><span class="zmdi zmdi-format-valign-bottom"></span></a>';
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
    url: base_url + "posisi-iklan/item_task/apiList/onprocess",
    formatters: {
        "link-rua": function(column, row)
        {
            return '<a title="View Task" href="' + base_url + 'posisi-iklan/item_task/' + row.posisi_iklan_item_task_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.posisi_iklan_item_task_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Update Task" href="' + base_url + 'posisi-iklan/item_task/update_task/' + row.posisi_iklan_item_task_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.posisi_iklan_item_task_id + '"><span class="zmdi zmdi-alert-triangle"></span></a>';
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
    url: base_url + "posisi-iklan/item_task/apiList/finished",
    formatters: {
        "link-rua": function(column, row)
        {
            return '<a title="View Task" href="' + base_url + 'posisi-iklan/item_task/' + row.posisi_iklan_item_task_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.posisi_iklan_item_task_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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
    $("#grid-data-available").bootgrid("reload");
    $("#grid-data-finished").bootgrid("reload");
}