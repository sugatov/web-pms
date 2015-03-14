ko.bindingHandlers.datepicker = {
    init: function(element, valueAccessor) {
         var options = valueAccessor();
         jQuery(element).datepicker(options);
    }  
};
