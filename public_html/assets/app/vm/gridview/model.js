define(['knockout-es5', 'jquery', 'text!./view.html'], function(ko, $, tpl) {
    ko.components.register('gridview', {
        viewModel: {
            createViewModel: function (params, componentInfo) {
                var vm = function (params, componentInfo) {
                    var self      = this;
                    this.items    = params.items;
                    this.columns  = params.columns;
                    this.onSelect = params.onSelect;
                    this.search   = params.search;
                    this.element  = $(componentInfo.element);

                    ko.track(this, ['items', 'columns']);

                    ko.defineProperty(this, 'haveSearch', function () {
                        if (typeof self.search === 'function') {
                            return true;
                        }
                        return false;
                    });

                    this.selectItem = function(item, event) {
                        self.element.find('tbody tr').removeClass('active');
                        $(event.currentTarget).addClass('active');
                        if (typeof self.onSelect === 'function') {
                            self.onSelect(item);
                        };
                    };
                };

                return new vm(params, componentInfo);
            }
        },
        template: tpl
    });
});
