/**
 * Controller shifts calendar page
 * 
 * @author markov
 */
var ShiftsCalendarController = {
    
    data: {},
    
    current: {},
    
    /**
     * Init
     */
    init: function(data) {
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
            refreshMonthTitle(calendar);
        });
        $('.font-chevron-right').parent('.item').on('click', function() {
            calendar.next();
            refreshMonthTitle(calendar);
        });
        calendar.source(function(beginDate, endDate, provide) {
            self.current.beginDate = beginDate;
            self.current.endDate = endDate;
            $.ajax({
                type: "POST",
                url: self.data.sourceUrl,
                data: {
                    start: beginDate.format('YYYY-MM-DD'),
                    end: endDate.format('YYYY-MM-DD'),
                    storeId: self.data.storeId
                },
                success: function(result) {
                    self.renderStateCounts(result.events);
                    provide(result.events);
                },
                dataType: 'json'
            });
        });
        calendar.onEventClick(function(event) {
            $.pjax({ 
                url: event.data.url, 
                container: '#shift-form-widget-pjax' 
            });
            $('.sidebar-container').removeClass('without-col-left');
        });
        
        $('#shift-add-bth').on('click', function() {
            $.pjax({ 
                url: $(this).attr('href'), 
                container: '#shift-form-widget-pjax' 
            });
            $('.sidebar-container').removeClass('without-col-left');
            return false;
        });
        
        $('#shift-form-widget-pjax').on('pjax:complete', function() {
            colorBoxInit();
            calendar.sourceCallbacksCall();
        });
        this.copyWeeklySheetInit();
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
                url: self.data.copyWeeklySheetUrl
            });
            
        });
    }
};