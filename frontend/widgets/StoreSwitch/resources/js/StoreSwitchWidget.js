var StoreSwitchWidget = {
    init: function (url, redirectUrl) {
        $('#switchCurrentStore').change(function() {
            var selectedStoreId = $(this).val();
            $.ajax({
                type: "POST",
                data: {
                    storeId: selectedStoreId 
                },
                url: url,
            }).done(function(){
                location.href = redirectUrl;
            });
        });
    }
};
