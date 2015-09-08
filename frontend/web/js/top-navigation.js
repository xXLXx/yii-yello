var now = moment();

setInterval(function(){
    $('#todaysdate').text(now.tz(TIMEZONE).format('MMM DD, YYYY'));
    $('#todaystime').text(now.tz(TIMEZONE).format('hh:mm A'));
    now = moment();
}, 1000);