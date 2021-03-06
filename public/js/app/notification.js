$(document).ready(function(){
	loadNotification();
	setInterval(function(){ 
		loadNotification(); 
	}, 60000); //check every 1 minute

	$("body").on("click",".notification-delete" ,function() {
		var notif_id = $(this).data('notif-id');
		deleteNotification(notif_id);
		loadAllNotification();
		loadNotification();
		return false;
	});
});

$('#notification_lists').on('click', '.notification-item', function(){
	var notification_id = $(this).data('notification_id');

	readNotification(notification_id);
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
				$('#notification_count').empty();
				$.each(data.notifications, function(key, value) {
					html += '<a class="lv-item notification-item" href="' + base_url + value.notification_type_url + '" title="' + value.notification_text + '" data-notification_id="' + value.notification_id + '">'
                                +'<div class="media">'
                                    +'<div class="pull-left">'
                                        +'<img class="lv-img-sm" src="' + base_url + 'img/avatar/' + value.user_avatar + '" alt="">'
                                    +'</div>'
                                    +'<div class="media-body">'
                                        +'<div class="lv-title">' + value.user_firstname + ' ' + value.user_lastname + '</div>'
                                        +'<small class="lv-small">' + value.notification_text + '</small>'
                                    +'</div>'
                                +'</div>'
                            +'</a>';
                    //notify(value.notification_text, 'info');
                    if(value.notification_status == 0) {
                    	sendNotification(value.notification_id, value.notification_text, 'info');
                    }
				});
				$('#notification_lists').append(html);
				$('#notification_count').append(data.total);
			}
		}
	});
}

function notify(message, notifType) {
	$.bootstrapGrowl(message, {
	  ele: 'body', // which element to append to
	  type: notifType, // (null, 'info', 'danger', 'success')
	  offset: {from: 'top', amount: 100}, // 'top', or 'bottom'
	  align: 'right', // ('left', 'right', or 'center')
	  width: 'auto', // (integer, or 'auto')
	  delay: 4000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
	  allow_dismiss: true, // If true then will display a cross to close the popup.
	  stackup_spacing: 10 // spacing between consecutively stacked growls.
	});
}

function sendNotification(notificationID, message, notifType) {
	$.ajax({
		url: base_url + 'api/sendNotification',
		type: 'POST',
		data: {
				'notification_id' : notificationID,
				'_token' : $('meta[name="csrf-token"]').attr('content'),
				'notification_status' : 1
				},
		dataType: 'json',
		success: function(data) {
			if(data == 'success') {
				console.log('Sending Notification Success');
				notify(message, notifType);
			}else{
				console.log('Sending Notification Failed');
			}
		}
	});
}

function readNotification(notificationID) {
	$.ajax({
		url: base_url + 'api/readNotification',
		type: 'POST',
		data: {
				'notification_id' : notificationID,
				'_token' : $('meta[name="csrf-token"]').attr('content')
				},
		dataType: 'json',
		success: function(data) {
			if(data == 'success') {
				console.log('Read Notification Success');
			}else{
				console.log('Read Notification Failed');
			}
		}
	});	
}

function deleteNotification(notificationID) {
	$.ajax({
		url: base_url + 'api/deleteNotification',
		type: 'POST',
		data: {
				'notification_id' : notificationID,
				'_token' : $('meta[name="csrf-token"]').attr('content')
				},
		dataType: 'json',
		success: function(data) {
			if(data == 'success') {
				console.log('Delete Notification Success');
			}else{
				swal('danger', 'Delete Notification Failed');
			}
		}
	});	
}

function loadAllNotification() {
	$.ajax({
		url: base_url + 'api/loadAllNotification',
		type: 'GET',
		dataType: 'json',
		success: function(data) {
			var html = '';
			$('#notification_all_container').empty();
			$.each(data.notifications, function(key, value) {
				html += '<a class="lv-item" href="' + base_url + value.notification_type_url + '" title="' + value.notification_text + '" data-notification_id="' + value.notification_id + '">'
                            +'<div class="media">'
                                +'<div class="pull-left">'
                                    +'<img class="lv-img-sm" src="' + base_url + 'img/avatar/' + value.user_avatar + '" alt="">'
                                +'</div>'
                                +'<div class="pull-right">'
                                +'<button type="button" class="close notification-delete" data-notif-id="' + value.notification_id + '" aria-label="Close"><span aria-hidden="true">×</span></button>'
                                +'</div>'
                                +'<div class="media-body">'
                                    +'<div class="lv-title">' + value.user_firstname + ' ' + value.user_lastname + '</div>'
                                    +'<small class="lv-small">' + value.notification_text + '</small>'
                                +'</div>'
                            +'</div>'
                        +'</a>';
			});
			$('#notification_all_container').append(html);
		}
	});
}