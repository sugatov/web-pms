define(['knockout', 'jquery', 'jquery-ui/dialog'], function (ko, $, dialog) {
    ko.bindingHandlers.dialog = {
        init: function(element, valueAccessor) {
            var options = valueAccessor();
            dialog(options, $(element));
        }  
    };
});
