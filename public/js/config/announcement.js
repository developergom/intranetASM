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
    url: base_url + "config/announcement/apiList",
    formatters: {
        "link-rud": function(column, row)
        {
            return '<a title="View Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Announcement" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-ru": function(column, row)
        {
            return '<a title="View Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '/edit" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-rd": function(column, row)
        {
            return '<a title="View Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Announcement" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Announcement" href="' + base_url + 'config/announcement/' + row.announcement_id + '" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.announcement_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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
            url: base_url + 'config/announcement/apiDelete',
            type: 'POST',
            data: {
                'announcement_id' : delete_id,
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
});