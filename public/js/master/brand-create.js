$(document).ready(function(){
    $('#industry_id').change(function(){
        var industry_id = $(this).val();

        $.ajax({
            url: base_url + 'master/subindustry/apiGetOption',
            type: 'POST',
            data: {
                'industry_id' : industry_id,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function(data) {
                $('#subindustry_id').empty();
                swal({
                  title: "ERROR",
                  text: "Fetching data error!",
                  type: "warning"
                });
            },
            success: function(data) {
                //console.log(data);

                $('#subindustry_id').empty();
                $.each(data, function(i, item){
                    $('#subindustry_id').append('<option value="' + item.subindustry_id + '">' + item.subindustry_code + ' - ' + item.subindustry_name + '</option>');
                });

                $('#subindustry_id').selectpicker('refresh');
            }
        });
    });
});