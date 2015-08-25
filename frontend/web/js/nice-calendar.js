/**
 * @author markov
 */

function Calendar(container) {
    this._sourceCallbacks = [];
    this._clickCallbacks = [];
    this._container = container;
    this._data = {};
    this._events = [];
    this._data.beginDate = moment().startOf("isoweek");
    this._data.currentDate = moment();
    this._data.selectedId = "";
    this.refresh();
    this.render();
};

Calendar.prototype.getEventById = function(id) {
    for (var i in this._events) {
        if (this._events[i].id == id) {
            return this._events[i];
        }
    };
    return null;
};

Calendar.prototype.refresh = function() {
    this._data.days = this.getDays();
    this._data.eventGroups = this.eventGroups();
    this._data.shiftId = get_shift_id_url();
   // calendarInterval = setTimeout(popCal,2000);

};

// returns current shift id if there is one.
function get_shift_id_url() {
    var data = window.location.href.match(/shiftId=([^&]+)/);
    if (data) {
        console.log(data[1]);
        return data[1];
    }
    return 0;
}

Calendar.prototype.getDays = function() {
    var days = [
        {
            title: 'Mo'
        },
        {
            title: 'Tu'
        },
        {
            title: 'We'
        },
        {
            title: 'Th'
        },
        {
            title: 'Fr'
        },
        {
            title: 'Sa'
        },
        {
            title: 'Su'
        }
    ];
    var clone = this._data.beginDate.clone();
    for (var i in days) {
        days[i].dayNumber = clone.format('DD');
        days[i].day = clone.clone();
        clone.add(1, 'd');
    }
    return days;
};

Calendar.prototype.eventGroups = function() {
    var eventsGroupByDay = [];
    var days = this.getDays();
    for (var i in this._events) {
        for (var j in days) {
            if (this._events[i].date.format('YYYY-MM-DD') !== days[j].day.format('YYYY-MM-DD')) {
                continue;
            }
            if (eventsGroupByDay[j] === undefined) {
                eventsGroupByDay[j] = [];
            }
            eventsGroupByDay[j].push(this._events[i]);
        }
    }
    
    var maxLength = 0;
    for (var i in eventsGroupByDay) {
        var length = eventsGroupByDay[i].length;
        if (length > maxLength) {
            maxLength = length;
        }
    }
    
    return {
        groups: eventsGroupByDay,
        maxLength: maxLength
    };
};

Calendar.prototype.source = function(callback) {
    this._sourceCallbacks.push(callback);
    this.sourceCallbacksCall();
};

// populate the day?
Calendar.prototype.sourceCallbacksCall = function() {
    var self = this;
    var endDate = this._data.beginDate.clone();
    endDate.add(7, 'd');
    for (var i in this._sourceCallbacks) {
        this._sourceCallbacks[i].call(self, 
            this._data.beginDate, endDate, function(eventsRaw) {
                self._events = [];
                for (var i in eventsRaw) {
                    var event = new Calendar.Event(eventsRaw[i]);
                    self._events.push(event);
                }
                // temporarily omitted as suspected not necessary
                self.refresh();
                self.render();
            }
        );
    }
};


Calendar.prototype.getContainer = function() {
    return $(this._container);
};

// a single event
Calendar.Event = function(data) {
    this.date = moment(data.date, 'YYYY-MM-DD');
    this.begin = data.begin;
    this.end = data.end;
    this.title = data.title;
    this.id = data.id;
    this.applicantsCount = data.applicantsCount;
    this.data = data.data;
    this.driverDeliveryCount = data.driverDeliveryCount;
};

Calendar.View = function() {
    
};

// cell render
Calendar.prototype.render = function() {
    var compiled = _.template(
        '<table class="calendar-table">' +
            '<thead>' +
                '<tr>' +
                    '<% _.each(days, function(item) { %>' +
                    '<th>' +
                        '<div class="wi wi-day-cloudy <% if (item.day.format(\'YYYY-MM-DD\') == currentDate.format(\'YYYY-MM-DD\')) { %> active<% } %>">' +
                            '<span><%= item.title %>, <%= item.day.format(\'DD\') %></span>' +
                        '</div>' +
                    '</th>' +
                    '<% }); %>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
                '<% for (var i = 0; i < eventGroups.maxLength+1; i++) { %>' +
                    '<tr>' +
                        '<% for (var j = 0; j < 7; j++) { %>' +
                            '<% if (eventGroups.groups[j] && eventGroups.groups[j][i] && eventGroups.groups[j][i].id==currentselected )  {%>'+
                                
                                '<td class="js-event" data-event-id="<%= eventGroups.groups[j][i].id %>">' +
                                    '<div class="calendar-table-item active <%=  eventGroups.groups[j][i].data.color %>" id="tableitem-<%= eventGroups.groups[j][i].id %>">' +
                                        '<a class="calendar-table-cell">' +
                                            '<%= eventGroups.groups[j][i].begin %> to <%= eventGroups.groups[j][i].end %>' +
                                            '<span class="bold-text"><%= eventGroups.groups[j][i].title %></span>' +
                                            '<% if (eventGroups.groups[j][i].applicantsCount) { %>' +
                                                '<span class="cell-count"><%= eventGroups.groups[j][i].applicantsCount %></span>' +
                                            '<% } %>' +
                                        '</a>' +
                                    '</div>' +
                                '</td>' +
                            '<% } else { %>' +
                               '<% if (eventGroups.groups[j] && eventGroups.groups[j][i]) {%>'+
                                
                                '<td class="js-event" data-event-id="<%= eventGroups.groups[j][i].id %>">' +
                                    '<div class="calendar-table-item <%=  eventGroups.groups[j][i].data.color %>" id="tableitem-<%= eventGroups.groups[j][i].id %>">' +
                                        '<a class="calendar-table-cell">' +
                                            '<%= eventGroups.groups[j][i].begin %> to <%= eventGroups.groups[j][i].end %>' +
                                            '<span class="bold-text"><%= eventGroups.groups[j][i].title %></span>' +
                                            '<% if (eventGroups.groups[j][i].applicantsCount) { %>' +
                                                '<span class="cell-count"><%= eventGroups.groups[j][i].applicantsCount %></span>' +
                                            '<% } %>' +
                                        '</a>' +
                                    '</div>' +
                                '</td>' +
                            '<% } else { %>' +
                                '<td style="" valign="bottom" class="emptyrosterspace" data-day="<%= j %>">'+
                                     '<% if (i==eventGroups.maxLength) {%>'+
                                     ''+
                                     '<% } %>' +
                                '</td>' +
                            '<% } %>' +
                            '<% } %>' +
                        '<% } %>' +
                    '</tr>' +
                '<% } %>' +
            '</tbody>' +
        '<table>'
    );
    var html = compiled(this._data);
    this.getContainer().html(html);
    this.eventClickInit();
};

Calendar.prototype.setBeginDate = function(date) {
    this._data.beginDate = date;
};

Calendar.prototype.setDateInterval = function(interval) {
    this._data.interval = interval;
}


// navigate between weeks
Calendar.prototype.next = function() {
    begindate=begindate+7;
    this._data.beginDate.add(7, 'd');
    this.sourceCallbacksCall();
    this.refresh();
    this.render();
};

Calendar.prototype.prev = function() {
    begindate=begindate-7;
    this._data.beginDate.subtract(7, 'd');
    this.sourceCallbacksCall();
    this.refresh();
    this.render();
};

Calendar.prototype.today = function(){
    this._data.beginDate.subtract(begindate, 'd');
    begindate=0;
    this.sourceCallbacksCall();
    this.refresh();
    this.render();
}


Calendar.prototype.again = function(){
    this.sourceCallbacksCall();
    this.refresh();
    this.render();
}


Calendar.prototype.onEventClick = function(callback) {
    console.log(new Date);
    this._clickCallbacks.push = callback;
};

Calendar.prototype.eventClickInit = function() {
    var self = this;
    
    $(".emptyrosterspace").on('click, touchend', function(){
        
    });
    
    $('.js-event', this.getContainer()).on('click', function() {
        // remove active cell
        $('.js-event', self.getContainer()).find('.calendar-table-item').removeClass('active');
        $(this).find('.calendar-table-item').addClass('active'); // set active
        var eventId = $(this).data('event-id');
        currentselected=eventId; // update the currently selected event
        var event = self.getEventById(eventId);
        for (var i in self._clickCallbacks) {
            self._clickCallbacks[i].call(self, event);
        };
    });
};