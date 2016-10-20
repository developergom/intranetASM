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
    url: base_url + "master/media/apiList",
    formatters: {
        "link-crud": function(column, row)
        {
            return '<a title="Add Edition" href="javascript:void(0)" class="btn btn-icon command-add-edition waves-effect waves-circle" type="button" data-row-media="' + row.media_name + '" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Media" href="' + base_url + 'master/media/' + row.media_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Media" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-cru": function(column, row)
        {
            return '<a title="Add Edition" href="javascript:void(0)" class="btn btn-icon command-add-edition waves-effect waves-circle" type="button" data-row-media="' + row.media_name + '" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Media" href="' + base_url + 'master/media/' + row.media_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-crd": function(column, row)
        {
            return '<a title="Add Edition" href="javascript:void(0)" class="btn btn-icon command-add-edition waves-effect waves-circle" type="button" data-row-media="' + row.media_name + '" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Media" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-rud": function(column, row)
        {
            return '<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Media" href="' + base_url + 'master/media/' + row.media_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Media" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-cr": function(column, row)
        {
            return '<a title="Add Edition" href="javascript:void(0)" class="btn btn-icon command-add-edition waves-effect waves-circle" type="button" data-row-media="' + row.media_name + '" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;'
                    +'<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
        },
        "link-ru": function(column, row)
        {
            return '<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Media" href="' + base_url + 'master/media/' + row.media_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-rd": function(column, row)
        {
            return '<a title="View Media" href="' + base_url + 'master/media/' + row.media_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Media" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="Add Edition" href="javascript:void(0)" class="btn btn-icon command-add-edition waves-effect waves-circle" type="button" data-row-media="' + row.media_name + '" data-row-id="' + row.media_id + '"><span class="zmdi zmdi-collection-plus"></span></a>&nbsp;&nbsp;';
        },
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
            url: base_url + 'master/media/apiDelete',
            type: 'POST',
            data: {
                'media_id' : delete_id,
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

    $('#grid-data').find(".command-add-edition").on("click", function(e)
    {
        var media_id = $(this).data('row-id');
        var media_name = $(this).data('row-media');

        $('input[name="media_id"]').val(media_id);
        $('#media_name').val(media_name);

        $('#modalAddMediaEdition').modal();
    });
});