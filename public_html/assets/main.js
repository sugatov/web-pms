require(
    [
        'less',
        'knockout-es5',
        'app/app',
        'jquery',
        'common/datasource',
        'app/vm/datagrid/model',
        'knockout-jqueryui/dialog',
        'common/confirmation-dialog'
    ],
    function(less, ko, app, $, datasource) {
        var vm = function () {
            var self = this;
            this.showDialog = false;
            this.categories = [];
            this.columns = [
                {
                    name: 'id',
                    displayName: 'ID'
                },
                {
                    name: 'name',
                    displayName: 'Имя'
                },
                {
                    name: 'price',
                    displayName: 'Цена'
                }
            ];
            app.rest.list('RoomCategory', function (list) {
                self.categories = list;
            });
            

            ko.track(this);

            this.dlgShow = function () {
                self.showDialog = true;
            };
            this.dlgHide = function () {
                self.showDialog = false;
            };

            this.source = new datasource('RoomCategory', this.columns, {});

            this.log = function (val) {
                console.log(val);
            };
        };
        ko.applyBindings(new vm());
    }
);
