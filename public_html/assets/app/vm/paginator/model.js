define(['knockout-es5', 'text!./view.html'], function(ko, tpl) {
    ko.components.register('paginator', {
        viewModel: function (params) {
            var self      = this;
            this.page     = params.page;
            this.count    = params.count;
            this.onChange = params.onChange;
            
            ko.track(this, ['page', 'count']);

            this.isValid = function () {
                if (isNaN(self.page) || self.page > self.count || self.page < 1) {
                    return false;
                }
                return true;
            };
            this.normalize = function () {
                if (isNaN(self.page)) {
                    self.page = 1;
                    return;
                }
                if (self.page > self.count) {
                    self.page = self.count;
                    return;
                }
                if (self.page < 1) {
                    self.page = 1;
                }
            };

            ko.getObservable(self, 'page').subscribe(function (val) {
                if ( ! self.isValid()) {
                    self.normalize();
                } else {
                    self.onChange(val);
                }
            });
            
            this.forward = function () {
                if (self.page < self.count) {
                    self.page += 1;
                }
            };
            this.backward = function () {
                if (self.page > 1) {
                    self.page -= 1;
                }
            };
        },
        template: tpl
    });
});
