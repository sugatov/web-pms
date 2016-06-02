define(['knockout-es5', 'text!./view.html', 'lodash/collection/find', './search-criterion/model'], function(ko, tpl, find) {
    ko.components.register('gridview', {
        viewModel: {
            createViewModel: function (params, componentInfo) {
                var vm = function (params, componentInfo) {
                    var self            = this;
                    this.items          = params.items;
                    this.columns        = params.columns;
                    this.onSelect       = params.onSelect;
                    this.search         = params.search;
                    this.searchCriteria = [];
                    this.selectedId     = -1;
                    this.element        = componentInfo.element;

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
                    
                    this.criterionChange = function (criterion) {
                        if (self.haveSearch) {
                            var existing = find(self.searchCriteria, {name: criterion.name});
                            if (existing === undefined && criterion.value.length > 0) {
                                self.searchCriteria.push(criterion);
                            } else {
                                if (criterion.value.length > 0) {
                                    existing.value = criterion.value;
                                } else {
                                    var index = self.searchCriteria.indexOf(existing);
                                    self.searchCriteria.splice(index, 1);
                                }
                            }
                            var criteria = {};
                            for (var i = 0; i < self.searchCriteria.length; i++) {
                                var column = self.searchCriteria[i];
                                criteria[column.name] = column.value;
                            };
                            self.search(criteria);
                        }
                    };

                    this.selectItem = function(item, event) {
                        self.selectedId = item.id;
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
