;(function ($, document) {

    'use strict';
    var dateWidget = {

            init: function () {

                dateWidget.$block = $('#shifts-date-widget');
                dateWidget.$date = dateWidget.$block.find('#date-input');

                dateWidget.setup();
            },
            setup: function () {

                dateWidget.$date.datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function ( date, picker ) {

                        dateWidget.changeDateLabel(date);
                        
//                        setInterval('dateWidget.getShiftsForDate('+date+')',2000);
                        dateWidget.getShiftsForDate(date);
                    
                    }
                });
                dateWidget.$block.find('#bt-prev-date').click({delta: -1}, dateWidget.dateRewind);
                dateWidget.$block.find('#bt-next-date').click({delta: 1}, dateWidget.dateRewind);
                dateWidget.$block.find('#bt-calendar').click(dateWidget.showCalendar);
            },
            dateRewind: function ( event ) {

                var date = dateWidget.$date.val();

                date = new Date(date);
                date.setDate(date.getDate() + event.data.delta);
                date = dateWidget.formatDate(date);

                dateWidget.$date.val(date);
                dateWidget.changeDateLabel(date);
                dateWidget.getShiftsForDate(date);
            },
            getShiftsForDate: function ( date ) {
                searchWidget.$input.val('');
                $.ajax('/shift-list/list', {
                    data: { date: date },
                    dataType: 'json',
                    error: function (data) {},
                    success: function (data) {

                        dateWidget.pasteAjaxData(data);
                    },
                    type: 'GET'
                });
            },
            pasteAjaxData: function (data) {

                if ( data.listHtml ) {

                    $('#shifts-list').html(data.listHtml);
                }

                if ( data.quantityHtml ) {

                    $('#shifts-quantity').html(data.quantityHtml);
                }

                shiftView.pasteData({ viewHtml: '' });
            },
            formatDate: function (date) {

                var dateStr = '';

                dateStr += date.getFullYear();
                dateStr += '-';
                dateStr += date.getMonth() + 1;
                dateStr += '-';
                dateStr += date.getDate();

                return dateStr;
            },
            showCalendar: function () {

                dateWidget.$date.datepicker('show');
            },
            changeDateLabel: function (date) {

                var dateLabel = '',
                    momentDay = moment(new Date(date));

                if ( moment().format('YYYY-M-D') === momentDay.format('YYYY-M-D') ) {
                    dateLabel = 'Today';
                } else {
                    dateLabel = momentDay.format('MMM D');
                }

                $('#date-label').html(dateLabel);
            }
        },
        searchWidget = {

            init: function () {

                searchWidget.$input = $('#shifts-list-search');
                searchWidget.$input.keyup(searchWidget.driverNameFilter);
                searchWidget.$shiftsList = $('#shifts-list');
            },
            driverNameFilter: function () {
                var filterString = searchWidget.$input.val().toLowerCase();

                searchWidget.$shiftsList.find('.shift-item').each(function () {

                    var $that = $(this),
                        driverName = $that.find('.driver-name').text().toLowerCase();

                    if ( driverName.indexOf(filterString) === -1 ) {
                        $that.hide();
                    } else {
                        $that.show();
                    }
                });
            }
        },
        shiftView = {

            init: function () {

                shiftView.$shiftsList = searchWidget.$shiftsList || $('#shifts-list');
                shiftView.$shiftsList.on('click', '.shift-link', shiftView.showShift);
                shiftView.$container = $('#shift-detail-container');
                shiftView.$container.on('click', '#link-approve-shift', shiftView.approveShift);

                shiftView.$shiftsList.find('.shift-link').eq(0).click();
            },
            showShift: function () {

                var $that = $(this),
                    $shiftItem = $that.closest('.shift-item'),
                    data = {
                        shiftId: Number($that.data('shiftId'))
                    };

                if ( ! $shiftItem.hasClass('active') ) {

                    shiftView.$shiftsList.find('.active').removeClass('active');
                    $shiftItem.addClass('active');

                    shiftView.requestShift(data);
                }

                return false;
            },
            approveShift: function () {

                var $that = $(this),
                    data = {
                        shiftId: Number($that.data('shiftId')),
                        approved: 1,
                        reviewText: $('.j_driver-review').val(),
                        reviewStars: $('#w1').val()
                    };

                shiftView.requestShift(data);
                return false;
            },
            requestShift: function (data) {

                $.ajax('/shift-list/view', {
                    data: data,
                    dataType: 'json',
                    error: function (data) {},
                    success: function (data) {

                        shiftView.pasteData(data);
                    },
                    type: 'GET'
                });
            },
            pasteData: function (data) {

                if ( 'viewHtml' in data ) {

                    shiftView.$container.html(data.viewHtml);
                }
                if ( data.itemHtml && data.shiftId ) {

                    shiftView.$shiftsList.find('.shift-item[data-id=' + data.shiftId + ']').replaceWith(data.itemHtml);
                    shiftView.$shiftsList.find('.shift-item[data-id=' + data.shiftId + ']').addClass('active');
                }

                jQuery(".rating-loading").rating('refresh', {
                        showClear: false,
                        size: 'xs',
                        glyphicon: false,
                        showCaption: false,
                        ratingClass: 'star-block big'
                    }
                );
            }
        };


    $(document).ready(function () {

        dateWidget.init();
        searchWidget.init();
        shiftView.init();
    });

}(jQuery, document));