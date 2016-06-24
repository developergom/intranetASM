$('.btn-add-client-contact').click(function(){
    save_contact();
});

$('.btn-edit-client-contact').click(function(){
    edit_contact();
});

$('.btn-close-client-contact').click(function(){
    clear_modal();
});

function save_contact()
{
    var isValid = false;

    if($('#client_contact_name').val()=='')
    {
        $('#client_contact_name').parents('.form-group').addClass('has-error').find('.help-block').html('Contact Name Must Be Filled In.');
        $('#client_contact_name').focus();
        isValid = false;
    }else if($('input[name="client_contact_gender"]').val()=='')
    {
        $('input[name="client_contact_gender"]').parents('.form-group').addClass('has-error').find('.help-block').html('Gender Must Be Choosed On.');
        $('input[name="client_contact_gender"]').focus();
        isValid = false;
    }else if($('#client_contact_birthdate').val()=='')
    {
        $('#client_contact_birthdate').parents('.form-group').addClass('has-error').find('.help-block').html('Birth Date Must Be Filled In.');
        $('#client_contact_birthdate').focus();
        isValid = false;
    }else if($('#religion_id').val()=='')
    {
        $('#religion_id').parents('.form-group').addClass('has-error').find('.help-block').html('Religion Must Be Choosed On.');
        $('#religion_id').focus();
        isValid = false;
    }else if($('#client_contact_position').val()=='')
    {
        $('#client_contact_position').parents('.form-group').addClass('has-error').find('.help-block').html('Position Must Be Filled In.');
        $('#client_contact_position').focus();
        isValid = false;
    }else if($('#client_contact_email').val()=='')
    {
        $('#client_contact_email').parents('.form-group').addClass('has-error').find('.help-block').html('Email Must Be Filled In.');
        $('#client_contact_email').focus();
        isValid = false;
    }else if($('#client_contact_phone').val()=='')
    {
        $('#client_contact_phone').parents('.form-group').addClass('has-error').find('.help-block').html('Phone Must Be Filled In.');
        $('#client_contact_phone').focus();
        isValid = false;
    }else{
        $('#client_contact_name').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('input[name="client_contact_gender"]').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#client_contact_birthdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#religion_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#client_contact_position').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#client_contact_phone').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#client_contact_email').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValid = true;
    }

    if(isValid)
    {
        $.ajax({
            url: base_url + 'master/clientcontact/apiSave',
            type: 'POST',
            data: {
                'client_id' : $('input[name="client_id"]').val(),
                'client_contact_name' : $('#client_contact_name').val(),
                'client_contact_gender' : $('input[name="client_contact_gender"]').val(),
                'client_contact_birthdate' : $('#client_contact_birthdate').val(),
                'religion_id' : $('#religion_id').val(),
                'client_contact_position' : $('#client_contact_position').val(),
                'client_contact_email' : $('#client_contact_email').val(),
                'client_contact_phone' : $('#client_contact_phone').val(),
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            statusCode: {
                422: function(e) {
                  if('client_contact_email' in e.responseJSON)
                  {
                    var messages = e.responseJSON.client_contact_email;
                    $.each(messages, function(key, value){
                        $('#client_contact_email').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                    });
                  }

                  if('client_contact_phone' in e.responseJSON)
                  {
                    var messages = e.responseJSON.client_contact_phone;
                    $.each(messages, function(key, value){
                        $('#client_contact_phone').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                    });
                  }
                }
            },
            error: function() {
                swal("Failed!", "Saving data failed.", "error");
            },
            success: function(data) {
                if(data==100) 
                {
                    swal("Success!", "Your data has been saved.", "success");
                    $("#grid-data").bootgrid("reload");
                    $('.btn-close-client-contact').click();
                }else{
                    console.log(data);
                    swal("Failed!", "Saving data failed.", "error");
                }
            }
        });
    }
}

function clear_modal()
{
    $('#client_contact_name').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('input[name="client_contact_gender"]').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#client_contact_birthdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#religion_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#client_contact_position').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#client_contact_phone').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#client_contact_email').parents('.form-group').removeClass('has-error').find('.help-block').html('');

    $('input[name="client_id"]').val('');
    $('input[name="client_contact_gender"]').attr('checked', false);
    $('#client_contact_name').val('');
    $('#client_contact_birthdate').val('');
    $('#religion_id').val('');
    $('#client_contact_position').val('');
    $('#client_contact_email').val('');
    $('#client_contact_phone').val('');
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