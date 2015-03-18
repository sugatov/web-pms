ko.bindingHandlers.inputshim = {
    init: function(element, valueAccessor) {
        var type = element.getAttribute('type');
        switch (type) {
            case 'date':
                if ( ! Modernizr.inputtypes.date) {
                    jQuery(element).datepicker({
                        dateFormat: 'yy-mm-dd'
                    });
                }
                break;
        }
    }  
};
