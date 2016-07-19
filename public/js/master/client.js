$("#grid-data").bootgrid({
    rowCount: [5, 10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
    },
    url: base_url + "master/client/apiList",
    formatters: {
        "link-crud": function(column, row)
        {
            return '<a title="Add Client" href="javascript:void(0)" class="btn btn-icon command-add-contact waves-effect waves-circle" type="button" data-row-client="' + row.client_name + '" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Client" href="' + base_url + 'master/client/' + row.client_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Client" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-cru": function(column, row)
        {
            return '<a title="Add Client" href="javascript:void(0)" class="btn btn-icon command-add-contact waves-effect waves-circle" type="button" data-row-client="' + row.client_name + '" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Client" href="' + base_url + 'master/client/' + row.client_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-crd": function(column, row)
        {
            return '<a title="Add Client" href="javascript:void(0)" class="btn btn-icon command-add-contact waves-effect waves-circle" type="button" data-row-client="' + row.client_name + '" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Client" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-rud": function(column, row)
        {
            return '<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Client" href="' + base_url + 'master/client/' + row.client_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Client" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-cr": function(column, row)
        {
            return '<a title="Add Client" href="javascript:void(0)" class="btn btn-icon command-add-contact waves-effect waves-circle" type="button" data-row-client="' + row.client_name + '" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        },
        "link-ru": function(column, row)
        {
            return '<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Client" href="' + base_url + 'master/client/' + row.client_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-rd": function(column, row)
        {
            return '<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Client" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Client" href="' + base_url + 'master/client/' + row.client_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    $("#grid-data").find(".command-delete").on("click", function(e)
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
            url: base_url + 'master/client/apiDelete',
            type: 'POST',
            data: {
                'client_id' : delete_id,
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
                    $("#grid-data").bootgrid("reload");
                }else{
                    swal("Failed!", "Deleting data failed.", "error");
                }
            }
          });

          
        });
    });

    $('#grid-data').find(".command-add-contact").on("click", function(e)
    {
        var client_id = $(this).data('row-id');
        var client_name = $(this).data('row-client');

        $('input[name="client_id"]').val(client_id);
        $('#client_name').val(client_name);

        $('#modalAddClientContact').modal();
    });
});