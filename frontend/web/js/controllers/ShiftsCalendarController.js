/**
 * Controller shifts calendar page
 *
 * @author markov
 * @updates pottie
 */

var calendarObject;
var calendarInterval;
var begindate=0;
var currentselected=0;
var pjaxTimeout = 0;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function popCal(){
    calendarObject.again();
}
var ShiftsCalendarController = {

    data: {},

    current: {},

    /**
     * Init
     */
    init: function(data) {
        var shid = getParameterByName('shiftId');
        if(shid!==null){
            currentselected = shid;
        }
        var self = this;
        this.data = data;
        function refreshMonthTitle(calendar) {
            var monthTitle = calendar._data.beginDate.format('MMMM YYYY');
            $('.js-month-title').html(monthTitle);
        };

        var calendar = new Calendar('.calendar-wrapper');
        refreshMonthTitle(calendar);
        $('.font-chevron-left').parent('.item').on('click', function() {
            calendar.prev();
            calendarObject = calendar;
            refreshMonthTitle(calendar);
        });
        $('.font-chevron-right').parent('.item').on('click', function() {
            calendar.next();
            calendarObject = calendar;
            refreshMonthTitle(calendar);
        });
        $('#choosetoday').on('click', function() {
            calendar.today();
            calendarObject = calendar;
            refreshMonthTitle(calendar);
        });
        $('.datepicker-group').on('click', function () {
            $(this).find('.hasDatepicker').datepicker('show');
            $(this).find('.hasDatepicker').on('change', function () {
                var pickerDate = $(this).datepicker('getDate');

                var dateEnd = new Date();
                var beginDateDiff = begindate;
                dateEnd.setDate(dateEnd.getDate() + 7 - dateEnd.getDay() + beginDateDiff);
                var dateStart = new Date(dateEnd);
                dateStart.setDate(dateStart.getDate() - 6);
                while (pickerDate < dateStart) {
                   beginDateDiff -= 7;
                   dateStart.setDate(dateStart.getDate() - 7);
                   dateEnd.setDate(dateEnd.getDate() - 7);
                }
                while (pickerDate > dateEnd) {
                    beginDateDiff += 7;
                   dateStart.setDate(dateStart.getDate() + 7);
                   dateEnd.setDate(dateEnd.getDate() + 7);
                }

                beginDateDiff -= begindate;
                begindate += beginDateDiff;
                calendar._data.beginDate.add(beginDateDiff, 'd');
                calendar.again();

                calendarObject = calendar;
                refreshMonthTitle(calendar);
            });
        });

        //setInterval(function(){ calendar.again(); }, 3000);
        calendar.source(function(beginDate, endDate, provide) {
            self.current.beginDate = beginDate;
            self.current.endDate = endDate;
            if(begindate==null){
                begindate=beginDate;
            }
            $.ajax({
                type: "POST",
                url: self.data.sourceUrl,
                data: {
                    start: beginDate.format('YYYY-MM-DD'),
                    end: endDate.format('YYYY-MM-DD'),
                    storeId: self.data.storeId,
                    shiftid: currentselected
                },
                success: function(result) {
                    self.renderStateCounts(result.events);
                    provide(result.events);
                    $("#tableitem-"+result.shiftid).addClass('active');
                },
                dataType: 'json'
            });
        });
        calendar.onEventClick(function(event) {
            $.pjax({
                url: event.data.url,
                container: '#shift-form-widget-pjax',
                timeout: pjaxTimeout
            });
                currentselected=event.id;
            $('.sidebar-container').removeClass('without-col-left');
        });

        $('#shift-add-bth').on('click touchend', function() {
            $.pjax({
                url: $(this).attr('href'),
                container: '#shift-form-widget-pjax',
                timeout: pjaxTimeout
            });
            $('.sidebar-container').removeClass('without-col-left');
            return false;
        });

        $('#shift-form-widget-pjax').on('pjax:beforeSend', function () {
            $(this).addClass('loading');
        });

        $('#shift-form-widget-pjax').on('pjax:complete', function() {
            colorBoxInit();
            calendar.sourceCallbacksCall();
            $(this).removeClass('loading');
        });
        this.copyWeeklySheetInit();
        calendarObject = calendar;
        calendarInterval = setInterval(popCal,2000);

    },



    /**
     * Render state counts
     */
    renderStateCounts: function(events) {
        var counts = {};
        var total = events.length;
        for (var i in events) {
            var stateId = events[i].data.shiftStateId;
            if (!counts[stateId]) {
                counts[stateId] = 0;
            }
            counts[stateId] ++;
        }
        var $container = $('.js-shift-states-count');
        $('.js-total .count', $container).html(total);
        $('.js-state-count .count', $container).html(0);
        for (var i in counts) {
            $('.js-state-id-' + i + ' .count', $container).html(counts[i]);
        }
    },

    /**
     * Init copy weekly sheet
     */
    copyWeeklySheetInit: function() {
        var self = this;
        $('.js-copy-weekly-sheet').on('click', function() {
            $.ajax({
                type: "POST",
                data: {
                    storeId: self.data.storeId,
                    start: self.current.beginDate.format('YYYY-MM-DD'),
                    end: self.current.endDate.format('YYYY-MM-DD')
                },
                url: self.data.copyWeeklySheetUrl,
                success: function(result) {
                    //if(result == "success"){
                        $('.js_roster_next').click();
                    //}
                }
            });

        });
    }
};
