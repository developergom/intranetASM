$('.btn-add-media-edition').click(function(){
    save_edition();
});

$('.btn-edit-media-edition').click(function(){
    edit_edition();
});

$('.btn-close-media-edition').click(function(){
    clear_modal();
});

function save_edition()
{
    var isValid = false;

    if($('#media_edition_no').val()=='')
    {
        $('#media_edition_no').parents('.form-group').addClass('has-error').find('.help-block').html('Edition No Must Be Filled In.');
        $('#media_edition_no').focus();
        isValid = false;
    }else if($('#media_edition_publish_date').val()=='')
    {
        $('#media_edition_publish_date').parents('.form-group').addClass('has-error').find('.help-block').html('Publish Date Must Be Filled In.');
        $('#media_edition_publish_date').focus();
        isValid = false;
    }else if($('#media_edition_deadline_date').val()=='')
    {
        $('#media_edition_deadline_date').parents('.form-group').addClass('has-error').find('.help-block').html('Deadline Date Must Be Filled In.');
        $('#media_edition_deadline_date').focus();
        isValid = false;
    }else{
        $('#media_edition_no').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#media_edition_publish_date').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#media_edition_deadline_date').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValid = true;
    }

    if(isValid)
    {
        $.ajax({
            url: base_url + 'master/mediaedition/apiSave',
            type: 'POST',
            data: {
                'media_id' : $('input[name="media_id"]').val(),
                'media_edition_no' : $('#media_edition_no').val(),
                'media_edition_publish_date' : $('#media_edition_publish_date').val(),
                'media_edition_deadline_date' : $('#media_edition_deadline_date').val(),
                'media_edition_desc' : $('#media_edition_desc').val(),
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function() {
                swal("Failed!", "Saving data failed.", "error");
            },
            success: function(data) {
                if(data==100) 
                {
                    swal("Success!", "Your data has been saved.", "success");
                    $("#grid-data").bootgrid("reload");
                    $('.btn-close-media-edition').click();
                }else{
                    swal("Failed!", "Saving data failed.", "error");
                }
            }
        });
    }
}

function clear_modal()
{
    $('input[name="media_id"]').val('');
    $('#media_name').val('');
    $('#media_edition_no').val('');
    $('#media_edition_publish_date').val('');
    $('#media_edition_deadline_date').val('');
    $('#media_edition_desc').val('');
}

function edit_edition()
{
    var isValidEdit = false;

    if($('#edit_media_edition_no').val()=='')
    {
        $('#edit_media_edition_no').parents('.form-group').addClass('has-error').find('.help-block').html('Edition No Must Be Filled In.');
        $('#edit_media_edition_no').focus();
        isValidEdit = false;
    }else 
    if($('#edit_media_edition_publish_date').val()=='')
    {
        $('#edit_media_edition_publish_date').parents('.form-group').addClass('has-error').find('.help-block').html('Publish Date Must Be Filled In.');
        $('#edit_media_edition_publish_date').focus();
        isValidEdit = false;
    }else
    if($('#edit_media_edition_deadline_date').val()=='')
    {
        $('#edit_media_edition_deadline_date').parents('.form-group').addClass('has-error').find('.help-block').html('Deadline Date Must Be Filled In.');
        $('#edit_media_edition_deadline_date').focus();
        isValidEdit = false;
    }else{
        $('#edit_media_edition_no').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_media_edition_publish_date').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_media_edition_deadline_date').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValidEdit = true;
    }

    if(isValidEdit)
    {
        $.ajax({
            url: base_url + 'master/mediaedition/apiEdit',
            type: 'POST',
            data: {
                'media_edition_id' : $('input[name="edit_media_edition_id"]').val(),
                'media_edition_no' : $('#edit_media_edition_no').val(),
                'media_edition_publish_date' : $('#edit_media_edition_publish_date').val(),
                'media_edition_deadline_date' : $('#edit_media_edition_deadline_date').val(),
                'media_edition_desc' : $('#edit_media_edition_desc').val(),
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function() {
                swal("Failed!", "Updating data failed.", "error");
            },
            success: function(data) {
                if(data==100) 
                {
                    swal("Success!", "Your data has been updated.", "success");
                    $("#grid-data").bootgrid("reload");
                    $('.btn-close-media-edition-edit').click();
                }else{
                    swal("Failed!", "Updating data failed.", "error");
                }
            }
        });
    }
}

function clear_edit_modal()
{
    $('input[name="edit_media_edition_id"]').val('');
    $('#edit_media_name').val('');
    $('#edit_media_edition_no').val('');
    $('#edit_media_edition_publish_date').val('');
    $('#edit_media_edition_deadline_date').val('');
    $('#edit_media_edition_desc').val('');
}