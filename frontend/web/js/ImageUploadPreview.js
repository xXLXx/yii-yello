var ImageUploadPreview = {

    options: {
        inputSelector: 'j_image-file-input',
        destinationSelector: 'j_image-file-destination'
    },

    init: function (options) {
        $.extend(this.options, options);
        this.initEvents();
    },

    initEvents: function () {
        var self = this;
        $('.' + this.options.inputSelector).on('change', uploadFiles);
        function uploadFiles(event) {
            var input = event.target,
                reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result,
                    $output = $('.' + self.options.destinationSelector);
                $output.attr('src', dataURL);
                $output.removeClass('hide');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
};
