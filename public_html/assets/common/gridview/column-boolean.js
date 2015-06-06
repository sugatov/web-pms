console.log('preload');
define(['knockout-es5', 'text!./column-boolean.html'], function (ko, tpl) {
    console.log('registering...');
    ko.components.register('gridview-column-boolean', {
        viewModel: function (params) {
            var self = this;
            this.value = params.value;
        },
        template: tpl
    });
});
