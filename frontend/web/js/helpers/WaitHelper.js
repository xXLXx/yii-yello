var WaitHelper = function() {
    this.timeout = null;
};

WaitHelper.prototype.wait = function(delay, callback) {
    clearTimeout(this.timeout);
    this.timeout = setTimeout(function() {
        callback();
    }, 300);
};