define(['knockout', 'modernizr'], function (ko, modernizr) {
    ko.bindingHandlers.inputshim = {
        init: function(element, valueAccessor) {
            var type = element.getAttribute('type');
            switch (type) {
                case 'date':
                    if ( ! modernizr.inputtypes.date) {
                        var ui = require('jquery-ui/datepicker');
                        jQuery(element).datepicker({
                            dateFormat: 'yy-mm-dd'
                        });
                    }
                    break;
            }
        }
    };
});
