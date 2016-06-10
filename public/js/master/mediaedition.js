$('.btn-add-media-edition').click(function(){
    save_edition();
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
    }else{
        $('#media_edition_no').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValid = true;
    } 

    if($('#media_edition_publish_date').val()=='')
    {
        $('#media_edition_publish_date').parents('.form-group').addClass('has-error').find('.help-block').html('Publish Date Must Be Filled In.');
        $('#media_edition_publish_date').focus();
        isValid = false;
    }else{
        $('#media_edition_publish_date').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValid = true;
    }

    if($('#media_edition_deadline_date').val()=='')
    {
        $('#media_edition_deadline_date').parents('.form-group').addClass('has-error').find('.help-block').html('Deadline Date Must Be Filled In.');
        $('#media_edition_deadline_date').focus();
        isValid = false;
    }else{
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