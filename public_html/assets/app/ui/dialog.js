define(['jquery-ui/dialog'], function (dialog) {
    return function (options) {
        // jQuery('<div></div>').appendTo('body').dialog(options);
        dialog(options, jQuery('<div></div>').appendTo('body'));
    };
});
