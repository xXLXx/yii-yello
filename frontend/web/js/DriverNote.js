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
            $row = $('.info-popup');
            $.ajax({
                type: 'POST',
                url: self.options.deleteNoteUrl,
                data: $('form').serialize(),
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
    }
};