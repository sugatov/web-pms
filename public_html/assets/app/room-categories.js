define(['knockout-es5',
       'text!./room-categories.html',
       'datasource',
       'datagrid',
       'knockout-jqueryui/dialog'
    ],
    function(ko, tpl, datasource) {
        ko.components.register('room-categories', {
            viewModel: function (params) {
                var self = this;
                this.perPage = (params.perPage) ? params.perPage : 10;
                this.selected = null;
                this.editing = null;
                this.createMode = false;
                this.columns = [
                    {
                        name: 'name',
                        displayName: 'Категория'
                    },
                    {
                        name: 'price',
                        displayName: 'Цена'
                    },
                    {
                        name: 'designation',
                        displayName: 'Обозначение'
                    }
                ];
                this.dataSource = new datasource('RoomCategory', this.columns, {});

                ko.track(this, ['selected', 'editing', 'createMode']);

                this.select = function (obj) {
                    self.selected = obj;
                };
                this.edit = function () {
                    self.createMode = false;
                    self.editing = self.selected;
                };
                this.del = function () {
                    if (confirm('Вы уверены?')) {
                        self.dataSource.delete(self.selected.id);
                        self.selected = null;
                    }
                };
                this.add = function () {
                    self.createMode = true;
                    self.dataSource.getDummy(function (dummy) {
                        self.editing = dummy;
                    });
                };

                this.editOK = function () {
                    if (self.createMode) {
                        self.dataSource.createObject(self.editing);
                    } else {
                        self.dataSource.updateObject(self.editing.id, self.editing);
                    }
                    self.closeEditor();
                    self.selected = null;
                };

                this.closeEditor = function () {
                    self.editing = null;
                };
            },
            template: tpl
        });
});
