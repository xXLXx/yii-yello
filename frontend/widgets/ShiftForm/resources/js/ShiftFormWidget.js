var ShiftFormWidget = {
    
    /**
     * Init
     */
    init: function() {
        var self = this;
        this.driverSearchShow($('.js-driver-group-radio:checked'));
        $('.js-driver-visible-group-container input[type=checkbox]').on('change',  
            function() {
                self.driverSearchShow($('.js-driver-group-radio:checked'),this);
            }
        );
    },
    
    driverSearchShow: function($container,obj)
    {
        var value = $container.val();
        var thisval = $(obj).val();
        var $driverSearchContainer = $('.js-driver-search-container');
        if($(obj).prop("checked")){
            if (thisval == 'isMyDrivers') {
                $driverSearchContainer.removeClass('hide');
                // disable others
                $('.js-driver-visible-group-container input[type=checkbox]').each(function(){
                    if($(this).val()!='isMyDrivers'){
                        console.log($(this));
                        $("label[for='" + this.id + "']").removeClass('active').addClass('disabled');
                        $(this).prop("checked",false);
                    }else{
                        console.log($(this));
                    }
                });
            } else {
                $('.js-driver-visible-group-container input[type=checkbox]').each(function(){
                if( $("label[for='driver-3']").hasClass("active")&&this.id!="driver-3"){
                        $("label[for='" + this.id + "']").removeClass('active').addClass('disabled');
                        $(this).prop("checked",false);
                    }
                });
             
            }
        }else{
            if (thisval == 'isMyDrivers') {
                $driverSearchContainer.addClass('hide');
                     $('.js-driver-visible-group-container input[type=checkbox]').each(function(){
                    if($(this).val()!='isMyDrivers'){
                        console.log($(this));
                        $("label[for='" + this.id + "']").removeClass('disabled');
                    }else{
                        console.log($(this));
                    }
                });                
            }            
        }
    }
};