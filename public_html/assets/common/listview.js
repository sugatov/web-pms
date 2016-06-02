define(['knockout-es5', 'text!./listview.html', './listview/search-criterion'], function(ko, tpl) {
    ko.components.register('listview', {
        viewModel: function (params) {
            var self        = this;
            this.items      = params.items;
            this.column     = params.column;
            this.search     = params.search;
            this.onSelect   = params.onSelect;
            this.selectedId = -1;

            ko.track(this, ['selectedId']);

            if (ko.isObservable(this.items)) {
                this.items.subscribe(function (val) {
                    self.selectedId = -1;
                });
            }

            ko.defineProperty(this, 'haveSearch', function () {
                if (typeof self.search === 'function') {
                    return true;
                }
                return false;
            });

            this.selectItem = function(item, event) {
                self.selectedId = item.id;
                if (typeof self.onSelect === 'function') {
                    self.onSelect(item);
                };
            };

            this.criterionChange = function (criterion) {
                console.log('criterionChange: '+criterion.value);
                if (self.haveSearch) {
                    var criteria = {};
                    criteria[column.name] = criterion.value;
                    self.search(criteria);
                }
            };

        },
        template: tpl
    });
});
