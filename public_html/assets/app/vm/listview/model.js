define(['knockout-es5', 'text!./view.html'], function(ko, tpl) {
    ko.components.register('listview', {
        viewModel: function (params) {
            this.items = params.items;
            this.column = params.column;
            ko.track(this);
        },
        template: tpl
    });
});
