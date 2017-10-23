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
    url: base_url + "workorder/summariesdelivered/apiList",
    formatters: {
        "link-ra": function(column, row)
        {
            return '<a title="View Summary" href="' + base_url + 'workorder/summariesdelivered/' + row.summary_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.summary_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Assign Summary" href="' + base_url + 'workorder/summariesdelivered/assigned/' + row.summary_id + '" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.summary_id + '"><span class="zmdi zmdi-assignment-alert"></span></a>&nbsp;&nbsp;';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Summary" href="' + base_url + 'workorder/summariesdelivered/' + row.summary_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.summary_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    }
});