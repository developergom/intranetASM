$("#grid-data").bootgrid({
    rowCount: [10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "workorder/summary/api/tbc_item_list",
    converters: {
        price: {
            from: function (value) { return value; },
            to: function (value) { return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); }
        }
    },
    formatters: {
        "link-r": function(column, row)
        {
            return '<a title="View Summary" href="' + base_url + 'workorder/summary/' + row.summary_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.summary_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    }
});