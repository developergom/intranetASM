$('.btn-add-client-contact').click(function(){
    save_contact();
});

$('.btn-edit-client-contact').click(function(){
    edit_contact();
});

$('.btn-close-client-contact').click(function(){
    clear_modal();
});

$('.btn-close-client-contact-edit').click(function(){
    clear_edit_modal();
});

$('.btn-close-client-contact-view').click(function(){
    clear_view_modal();
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
        var gender_value = 1;

        if($('#gender_male').is(':checked'))
        {
            gender_value = 1;
        }else{
            gender_value = 2;
        }

        $.ajax({
            url: base_url + 'master/clientcontact/apiSave',
            type: 'POST',
            data: {
                'client_id' : $('input[name="client_id"]').val(),
                'client_contact_name' : $('#client_contact_name').val(),
                'client_contact_gender' : gender_value,
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

    $('#religion_id').selectpicker('refresh');
}

function edit_contact()
{
    var isValidEdit = false;

    if($('#edit_client_contact_name').val()=='')
    {
        $('#edit_client_contact_name').parents('.form-group').addClass('has-error').find('.help-block').html('Contact Name Must Be Filled In.');
        $('#edit_client_contact_name').focus();
        isValidEdit = false;
    }else if($('input[name="edit_client_contact_gender"]').val()=='')
    {
        $('input[name="edit_client_contact_gender"]').parents('.form-group').addClass('has-error').find('.help-block').html('Gender Must Be Choosed On.');
        $('input[name="edit_client_contact_gender"]').focus();
        isValidEdit = false;
    }else if($('#edit_client_contact_birthdate').val()=='')
    {
        $('#edit_client_contact_birthdate').parents('.form-group').addClass('has-error').find('.help-block').html('Birth Date Must Be Filled In.');
        $('#edit_client_contact_birthdate').focus();
        isValidEdit = false;
    }else if($('#edit_religion_id').val()=='')
    {
        $('#edit_religion_id').parents('.form-group').addClass('has-error').find('.help-block').html('Religion Must Be Choosed On.');
        $('#edit_religion_id').focus();
        isValidEdit = false;
    }else if($('#edit_client_contact_position').val()=='')
    {
        $('#edit_client_contact_position').parents('.form-group').addClass('has-error').find('.help-block').html('Position Must Be Filled In.');
        $('#edit_client_contact_position').focus();
        isValidEdit = false;
    }else if($('#edit_client_contact_email').val()=='')
    {
        $('#edit_client_contact_email').parents('.form-group').addClass('has-error').find('.help-block').html('Email Must Be Filled In.');
        $('#edit_client_contact_email').focus();
        isValidEdit = false;
    }else if($('#edit_client_contact_phone').val()=='')
    {
        $('#edit_client_contact_phone').parents('.form-group').addClass('has-error').find('.help-block').html('Phone Must Be Filled In.');
        $('#edit_client_contact_phone').focus();
        isValidEdit = false;
    }else{
        $('#edit_client_contact_name').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('input[name="edit_client_contact_gender"]').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_client_contact_birthdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_religion_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_client_contact_position').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_client_contact_phone').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        $('#edit_client_contact_email').parents('.form-group').removeClass('has-error').find('.help-block').html('');
        isValidEdit = true;
    }

    if(isValidEdit)
    {
        var gender_value = 1;

        if($('#edit_gender_male').is(':checked'))
        {
            gender_value = 1;
        }else{
            gender_value = 2;
        }

        $.ajax({
            url: base_url + 'master/clientcontact/apiEdit',
            type: 'POST',
            data: {
                'client_contact_id' : $('input[name="edit_client_contact_id"]').val(),
                'client_contact_name' : $('#edit_client_contact_name').val(),
                'client_contact_gender' : gender_value,
                'client_contact_birthdate' : $('#edit_client_contact_birthdate').val(),
                'religion_id' : $('#edit_religion_id').val(),
                'client_contact_position' : $('#edit_client_contact_position').val(),
                'client_contact_email' : $('#edit_client_contact_email').val(),
                'client_contact_phone' : $('#edit_client_contact_phone').val(),
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            statusCode: {
                422: function(e) {
                  if('client_contact_email' in e.responseJSON)
                  {
                    var messages = e.responseJSON.client_contact_email;
                    $.each(messages, function(key, value){
                        $('#edit_client_contact_email').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                    });
                  }

                  if('client_contact_phone' in e.responseJSON)
                  {
                    var messages = e.responseJSON.client_contact_phone;
                    $.each(messages, function(key, value){
                        $('#edit_client_contact_phone').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                    });
                  }
                }
            },
            error: function() {
                swal("Failed!", "Updating data failed.", "error");
            },
            success: function(data) {
                if(data==100) 
                {
                    swal("Success!", "Your data has been updated.", "success");
                    $("#grid-data").bootgrid("reload");
                    $('.btn-close-client-contact-edit').click();
                }else{
                    swal("Failed!", "Updating data failed.", "error");
                }
            }
        });
    }
}

function clear_edit_modal()
{
    $('#edit_client_contact_name').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('input[name="edit_client_contact_gender"]').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#edit_client_contact_birthdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#edit_religion_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#edit_client_contact_position').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#edit_client_contact_phone').parents('.form-group').removeClass('has-error').find('.help-block').html('');
    $('#edit_client_contact_email').parents('.form-group').removeClass('has-error').find('.help-block').html('');

    $('input[name="edit_client_contact_id"]').val('');
    $('input[name="edit_client_contact_gender"]').attr('checked', false);
    $('#edit_client_contact_name').val('');
    $('#edit_client_contact_birthdate').val('');
    $('#edit_religion_id').val('');
    $('#edit_client_contact_position').val('');
    $('#edit_client_contact_email').val('');
    $('#edit_client_contact_phone').val('');

    $('#edit_religion_id').selectpicker('refresh');
}

function clear_view_modal()
{
    $('#view_client_name').val('');
    $('#view_client_contact_name').val('');
    $('#view_client_contact_gender').val('');
    $('#view_client_contact_birthdate').val('');
    $('#view_religion_id').val('');
    $('#view_client_contact_position').val('');
    $('#view_client_contact_email').val('');
    $('#view_client_contact_phone').val('');
}