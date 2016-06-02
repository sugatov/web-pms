define(['knockout-es5', 'text!./view.html', '../gridview/model', '../paginator/model', 'pager'], function(ko, tpl) {
    ko.components.register('datagrid', {
        viewModel: function (params) {
            var self                = this;
            this.dataSource         = params.dataSource;
            this.page               = 1;
            this.paginatorPage      = 1;
            this.perPage            = params.perPage;
            this.onSelectCallback   = params.onSelect;
            this.selectedId         = null;

            ko.defineProperty(this, 'pageCount', function () {
                return Math.ceil(this.dataSource.count / this.perPage);
            });
            
            ko.track(this, ['page', 'selectedId'] );

            ko.getObservable(this, 'page').subscribe(function (val) {
                self.setPage(val);
            });

            this.setPage = function(page) {
                self.dataSource.limit = self.perPage;
                self.dataSource.offset = self.perPage * (page - 1);
            };

            this.pageChange = function (val) {
                self.page = val;
                self.selectedId = null;
            };

            this.onSelect = function (val) {
                self.selectedId = val[self.dataSource.primaryKey];
                if (typeof self.onSelectCallback === 'function') {
                    self.onSelectCallback(val);
                }
            }

            this.search = function (criteria) {
                self.dataSource.filter = criteria;
                self.selectedId = null;
            };
            
            this.setPage(1);
        },
        template: tpl
    });
});
