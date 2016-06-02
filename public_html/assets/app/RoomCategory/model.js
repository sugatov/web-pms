define(['knockout-es5', 'text!./view.html', 'knockout-jqueryui/dialog'], function(ko, tpl) {
// define(['knockout-es5', 'text!./view.html'], function(ko, tpl) {
    ko.components.register('RoomCategory', {
        viewModel: function (params) {
            this.items = params.items;
            ko.track(this);
        },
        template: tpl
    });
});
