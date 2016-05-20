$("#grid-data").bootgrid({
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "/master/role/apiList",
    formatters: {
        "link": function(column, row)
        {
            //return "<a href=\"#\">" + column.id + ": " + row.role_id + "</a>";
            return '<a href="' + base_url + 'master/role/' + row.role_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.role_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a href="' + base_url + 'master/role/' + row.role_id + '/delete" class="btn btn-icon command-delete waves-effect waves-circle" type="button" data-row-id="' + row.role_id + '"><span class="zmdi zmdi-delete"></span></a>';
        }
    }
});