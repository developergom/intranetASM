$(document).ready(function() {
	$('#clear-all-cache').click(function() {
		swal({
          title: "Are you sure want to clear all cache on this application?",
          text: "You will not be able to recover this action!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, clear all!",
          closeOnConfirm: false
        },
        function(){
          $.ajax({
            url: base_url + 'config/cache-management/apiClearAll',
            type: 'POST',
            data: {
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            error: function() {
                swal("Failed!", "Clear all cache failed.", "error");
            },
            success: function(data) {
                if(data==200) 
                {
                    swal("Success!", "Your cache has been cleared.", "success");
                    location.reload();
                }else{
                    swal("Failed!", "Clear all cache failed.", "error");
                }
            }
          });

          
        });
	});
});