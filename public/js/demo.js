$(window).load(function(){
    //Welcome Message (not for login page)
    function notify(message, type){
        $.notify({
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
            },
            offset: {
                x: 20,
                y: 85
            }
        });
    };
    
    /*if (!$('.login-content')[0]) {
        notify('Welcome back Mallinda Hollaway', 'inverse');
    }*/ 
});
//# sourceMappingURL=demo.js.map
