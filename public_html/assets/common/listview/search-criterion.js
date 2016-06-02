define(['knockout-es5', 'text!./search-criterion.html'], function(ko, tpl) {
    ko.components.register('listview-search-criterion', {
        viewModel: function (params) {
            var self         = this;
            this.name        = params.column.name;
            this.displayName = params.column.displayName;
            this.value       = '';
            this.onChange    = params.onChange;
            
            ko.track(this);

            ko.getObservable(this, 'value').subscribe(function (val) {
                console.log('criterion: '+val);
                if (typeof self.onChange === 'function') {
                    self.onChange({
                        name: self.name,
                        displayName: self.displayName,
                        value: self.value
                    });
                }
            });
        },
        template: tpl
    });
});
