define(['knockout-es5', 'text!./view.html', '../gridview/model', '../paginator/model'], function(ko, tpl) {
    ko.components.register('datagrid', {
        viewModel: function (params) {
            var self                = this;
            this.dataSource         = params.dataSource;
            this.items              = [];
            this.columns            = params.dataSource.columns;
            this.page               = 1;
            this.paginatorPage      = 1;
            this.pageCount          = 1;
            this.perPage            = params.perPage;
            this.onSelectCallback   = params.onSelect;

            this.dataSource.count({}, function (cnt) {
                self.pageCount = Math.ceil(cnt / self.perPage);
            });
            this.dataSource.list(function (list) {
                self.items = list;
            }, self.perPage);
            
            ko.track(this, ['items', 'columns', 'page', 'pageCount']);

            this.pageChange = function (val) {
                self.page = val;
            };

            this.onSelect = function (val) {
                if (typeof self.onSelectCallback === 'function') {
                    self.onSelectCallback(val);
                }
            }

            this.search = function (criteria) {
                console.log(criteria);
            };

            ko.getObservable(self, 'page').subscribe(function (val) {
                self.dataSource.list(function (list) {
                    self.items = list;
                }, self.perPage, self.perPage * (val-1));
            });
        },
        template: tpl
    });
});
