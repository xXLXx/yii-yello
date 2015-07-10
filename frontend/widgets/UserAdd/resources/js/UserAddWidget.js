/**
 * @author markov
 */
var UserAddWidget = {
    
    data: {},
    
    /**
     * Инициализация
     */
    init: function(data) {
        this.data = data;
        this.initAdminPrivileges();
    },
    
    initAdminPrivileges: function() {
        var self = this;
        $('#useraddform-roleid').on('change', function() {
            if ($(this).val() == self.data.managerRoleId) {
                $('.js-admin-priv-container').removeClass('hide');
            } else {
                $('.js-admin-priv-container').addClass('hide');
            }
        });
    }
};