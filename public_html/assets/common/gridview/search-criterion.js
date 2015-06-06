define(['knockout-es5', 'text!./search-criterion.html'], function(ko, tpl) {
    ko.components.register('gridview-search-criterion', {
        viewModel: function (params) {
            var self      = this;
            this.name     = params.column.name;
            this.label    = params.column.label;
            this.search   = params.column.search;
            this.value    = '';
            this.onChange = params.onChange;

            ko.track(this);

            ko.getObservable(this, 'value').subscribe(function (val) {
                if (typeof self.onChange === 'function') {
                    self.onChange({
                        name: self.name,
                        label: self.label,
                        search: self.search,
                        value: self.value
                    });
                }
            });
        },
        template: tpl
    });
});
