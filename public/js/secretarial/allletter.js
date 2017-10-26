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
    url: base_url + "secretarial/allletter/apiList",
    formatters: {
        "link-r": function(column, row)
        {
            return '<a title="View Letter" href="' + base_url + 'secretarial/allletter/' + row.letter_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.letter_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    }
});