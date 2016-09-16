$(document).ready(function(){
	loadNotification();
});

function loadNotification() {
	$.ajax({
		url: base_url + 'api/loadNotification',
		type: 'GET',
		dataType: 'json',
		success: function(data) {
			if(data.total > 0) {
				var html = '';
				$('#notification_lists').empty();
				$.each(data.notifications, function(key, value) {
					html += '<a class="lv-item" href="#">'
                                +'<div class="media">'
                                    +'<div class="pull-left">'
                                        +'<img class="lv-img-sm" src="img/avatar/' + value.user_avatar + '" alt="">'
                                    +'</div>'
                                    +'<div class="media-body">'
                                        +'<div class="lv-title">' + value.user_firstname + ' ' + value.user_lastname + '</div>'
                                        +'<small class="lv-small">' + value.notification_text + '</small>'
                                    +'</div>'
                                +'</div>'
                            +'</a>';
				});
				$('#notification_lists').append(html);
			}
		}
	});
}