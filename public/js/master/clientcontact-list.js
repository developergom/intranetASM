$("#grid-data").bootgrid({
    rowCount: [5, 10, 25, 50],
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('input[name="_client_id"]').val()
        };
    },
    url: base_url + "master/clientcontact/apiList",
    formatters: {
        "link-rud": function(column, row)
        {
            return '<a title="View Contact" href="javascript:void(0)" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Contact" href="javascript:void(0)" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Contact" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-ru": function(column, row)
        {
            return '<a title="View Contact" href="javascript:void(0)" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Edit Contact" href="javascript:void(0)" class="btn btn-icon command-edit waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-edit"></span></a>&nbsp;&nbsp;';
        },
        "link-rd": function(column, row)
        {
            return '<a title="View Contact" href="javascript:void(0)" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;'
                    +'<a title="Delete Contact" href="javascript:void(0);" class="btn btn-icon btn-delete-table command-delete waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-delete"></span></a>';
        },
        "link-r": function(column, row)
        {
            return '<a title="View Contact" href="javascript:void(0)" class="btn btn-icon command-detail waves-effect waves-circle" type="button" data-row-id="' + row.client_contact_id + '"><span class="zmdi zmdi-more"></span></a>&nbsp;&nbsp;';
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
    $("#grid-data").find(".command-detail").on("click", function(e)
    {
        var page_data = $('#grid-data').bootgrid("getCurrentRows");
        var row_id = $(this).parent().parent().data('row-id'); 
        var current = page_data[row_id];

        /*console.log(current);*/

        $('#view_client_name').val(current.client_name);
        $('#view_client_contact_name').val(current.client_contact_name);
        if(current.client_contact_gender == '1')
        {
            $('#view_client_contact_gender').val('Male');
        }else{
            $('#view_client_contact_gender').val('Female');
        }
        $('#view_client_contact_birthdate').val(moment(current.client_contact_birthdate).format("DD/MM/YYYY"));
        $('#view_religion_id').val(current.religion_name);
        $('#view_client_contact_position').val(current.client_contact_position);
        $('#view_client_contact_email').val(current.client_contact_email);
        $('#view_client_contact_phone').val(current.client_contact_phone);

        $('#modalViewClientContact').modal();
    });

    $("#grid-data").find(".command-edit").on("click", function(e)
    {
        var page_data = $('#grid-data').bootgrid("getCurrentRows");
        var row_id = $(this).parent().parent().data('row-id'); 
        var current = page_data[row_id];

        /*console.log(current);*/

        $('input[name="edit_client_contact_id"]').val(current.client_contact_id);
        $('#edit_client_name').val(current.client_name);
        $('#edit_client_contact_name').val(current.client_contact_name);
        if(current.client_contact_gender=='1')
        {
            $('#edit_gender_male').prop('checked', true);
        }else
        {
            $('#edit_gender_female').prop('checked', true);
        }
        $('#edit_client_contact_birthdate').val(moment(current.client_contact_birthdate).format("DD/MM/YYYY"));
        $('#edit_religion_id').val(current.religion_id);
        $('#edit_client_contact_position').val(current.client_contact_position);
        $('#edit_client_contact_email').val(current.client_contact_email);
        $('#edit_client_contact_phone').val(current.client_contact_phone);

        $('#edit_religion_id').selectpicker('refresh');

        $('#modalEditClientContact').modal();
    });

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
            url: base_url + 'master/clientcontact/apiDelete',
            type: 'POST',
            data: {
                'client_contact_id' : delete_id,
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

$('.command-add-contact').click(function(){
    var client_id = $(this).data('row-id');
    var client_name = $(this).data('row-client');

    $('input[name="client_id"]').val(client_id);
    $('#client_name').val(client_name);

    $('#modalAddClientContact').modal();
});