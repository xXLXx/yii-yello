var ImageUploadPreview = {

    options: {
        inputSelector: 'j_image-file-input',
        destinationSelector: 'j_image-file-destination',
        hideDestination: false
    },

    init: function (options) {
        $.extend(this.options, options);
        this.initEvents();

        if (this.options.hideDestination) {
            $('.' + this.options.destinationSelector).hide();
        }
    },

    initEvents: function () {
        var self = this;
        $('.' + this.options.inputSelector).on('change', uploadFiles).data('destination', self.options.destinationSelector);
        function uploadFiles(event) {
            var input = event.target,
                reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result,
                    $output = $('.' + $(input).data('destination'));
                $output.attr('src', dataURL);
                $output.removeClass('hide');
                if (self.options.hideDestination) {
                    $output.show();
                    $output.closest('div').removeClass('no-photo');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
};
