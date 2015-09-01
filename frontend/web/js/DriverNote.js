/**
 * Adding and removing store owner's favourite drivers
 *
 * @type {{options: {inviteButtonSelector: string, removeButtonSelector: string, favouriteStar: string, addUrl: string, removeUrl: string}, init: Function, initEvents: Function}}
 */
var DriverNote = {

    /**
     * Options
     */
    options: {
        addNoteButtonSelector: '.j_add-note',
        deleteNoteSelector: '.j_note_delete',
        noteUrl: '/drivers/note',
        deleteNoteUrl: '/drivers/remove-note',
        rotatePhotoUrl: '/drivers/rotate-photo',
        changePaymentMethod: '/drivers/change-payment-method',
        cancelChangeRequest: '/drivers/cancel-payment-change'
    },

    /**
     * Initialization
     *
     * @param options
     */
    init: function (options) {
        $.extend(this.options, options);
        this.initEvents();
    },

    /**
     * Events initialization
     */
    initEvents: function () {
        var self = this;

        $(document).on('click', this.options.addNoteButtonSelector, function (e) {
            e.preventDefault();
            $row = $('.info-popup');
            $.ajax({
                type: 'POST',
                url: self.options.noteUrl,
                data: $('form').serialize(),
                success: function (data) {

                    if (data.search('success') != -1) {
                        var html = $('.success_message', data).html();
                        $('.j_add_note_link .note-item').html(html);
                        $(".j_colorbox").colorbox.close();
                        $(".j_add_note_link").removeClass('hidden');
                        return;
                    }

                    var html = $('#contact-form', $(data)).html();
                    $('#contact-form').html(html);
                    $(".j_colorbox").colorbox.resize();

                }
                //dataType: 'json'
            });
        });

        $(document).on('click', this.options.deleteNoteSelector, function (e) {
            e.preventDefault();

            driverId = $(this).data('driverid');

            $.ajax({
                type: 'GET',
                url: self.options.deleteNoteUrl,
                data: {id: driverId},
                success: function (data) {

                    if (data.success) {
                        $('.j_add_note_link .note-item').html('');
                        $(".j_add_note_link").addClass('hidden');
                        return;
                    }
                },
                dataType: 'json'
            });
        });



        $(document).on('click', '.j_photo_rotate', function (e) {
            e.preventDefault();
            driverId = $(this).data('driverid');
            $this = $(this);
            $.ajax({
                type: 'GET',
                url: self.options.rotatePhotoUrl,
                data: {id: driverId},
                success: function (data) {
                    if(data.success){
                        alert('Image Rotated');
                    } else {
                        alert('Image rotation failed!');
                    }
                   /* if (data.search('success') != -1) {
                        var html = $('.success_message', data).html();
                        $('.j_add_note_link .note-item').html(html);
                        $(".j_colorbox").colorbox.close();
                        $(".j_add_note_link").removeClass('hidden');
                        return;
                    }

                    var html = $('#contact-form', $(data)).html();
                    $('#contact-form').html(html);
                    $(".j_colorbox").colorbox.resize();*/

                },
                dataType: 'json'
            });
        });


        //@ToDo Lalit J - Shift to correct js file for payment method.
        $(document).on('submit', '#store-invite-driver-form-payment', function() {
            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'post',
                data: $form.serializeArray(),

                error: function(xhr){
                    console.log(xhr.responseText);
                },
                success: function(data) {

                    if (data.search && data.search('success') != -1) {
                        var html = $('.success_message', data).html();

                        $('#store-invite-driver-form-payment .popup-body-inner').html(html);

                        $(".j_colorbox").colorbox.resize();

                        $('#j_payment_change').addClass('hidden');
                        $('.j_cancel_payment_change').removeClass('hidden');


                        return;
                    }
                    var html = $('#store-invite-driver-form', $(data)).html();
                    $('#store-invite-driver-form').html(html);
                    $(".j_colorbox").colorbox.resize();
                }
            });
            return false;
        });

        $(document).on('click', '.j_cancel_payment_change', function (e) {
            e.preventDefault();
            $this = $(this);
            driverId = $this.data('driverid');
            $.ajax({
                type: 'GET',
                url: self.options.cancelChangeRequest,
                data: {driverId: driverId},
                success: function (data) {
                    if(data.success){
                        $('#j_payment_change').removeClass('hidden');
                        $('.j_cancel_payment_change').addClass('hidden');
                    }
                },
                dataType: 'json'
            });
        });
    }
};