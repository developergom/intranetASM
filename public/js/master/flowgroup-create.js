$(document).ready(function(){
  	$('#flow-wizard').bootstrapWizard({
  		tabClass: 'fw-nav', 
  		nextSelector: '.next', 
  		/*previousSelector: '.previous',*/
  		onNext: function(tab, navigation, index) {
			if(index==2) {
				// Make sure we entered the name
				if(!$('#name').val()) {
					alert('You must enter your name');
					$('#name').focus();
					return false;
				}
			}
			
			// Set the name for the next tab
			$('#tab3').html('Hello, ' + $('#name').val());
			
		}, 
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('#flow-wizard').find('.progress-bar').css({width:$percent+'%'});
		}});
});