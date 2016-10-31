$(document).ready(function(){
	$('#publisher_id').change(function(){
		var publisher_id = $(this).val();

		$.ajax({
			url : base_url + 'master/mediagroup/apiGetOption',
			type: 'POST',
            data: {
                'publisher_id' : publisher_id,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function(data) {
                $('#media_group_id').empty();
                swal({
                  title: "ERROR",
                  text: "Fetching data error!",
                  type: "warning"
                });
            },
            success: function(data) {
                $('#media_group_id').empty();
                $.each(data, function(i, item){
                    $('#media_group_id').append('<option value="' + item.media_group_id + '">' + item.media_group_name + '</option>');
                });

                $('#media_group_id').selectpicker('refresh');
            }
		});
	});
});