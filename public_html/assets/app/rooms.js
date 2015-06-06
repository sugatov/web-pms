define(['knockout-es5',
       'text!./rooms.html',
       'datasource',
       'datagrid',
       'knockout-jqueryui/dialog'
    ],
    function(ko, tpl, datasource) {
        ko.components.register('rooms', {
            viewModel: function (params) {
                var self = this;
                this.perPage = (params.perPage) ? params.perPage : 10;
                this.selected = null;
                this.editing = null;
                this.editingSelectedCategory = null;
                this.editingSelectCategory = false;
                this.createMode = false;
                this.columns = [
                    {
                        name: 'name',
                        displayName: 'Комната'
                    },
                    {
                        name: 'isAvailable',
                        displayName: 'Доступна'
                    }
                ];
                this.categoriesColumns = [
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

                this.dataSource = new datasource('Room', this.columns, {});
                this.categoriesDataSource = new datasource('RoomCategory', this.categoriesColumns, {});

                ko.track(this, [
                    'selected',
                    'editing',
                    'createMode',
                    'editingSelectedCategory',
                    'editingSelectCategory'
                ]);

                this.select = function (obj) {
                    self.selected = obj;
                };
                this.edit = function () {
                    self.createMode = false;
                    self.editing = ko.track(self.selected);
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
                        dummy.roomCategory = {};
                        self.editing = ko.track(dummy);
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

                this.selectCategory = function () {
                    self.editingSelectCategory = true;
                };
                this.selectCategoryOK = function (obj) {
                    self.editingSelectCategory = false;
                    self.editingSelectedCategory = obj;
                };
                this.selectCategoryCancel = function () {
                    self.editingSelectCategory = false;
                };
                ko.getObservable(this, 'editingSelectedCategory').subscribe(function (val) {
                    if (self.editing !== null) {
                        self.editing.roomCategory_id = val.id;
                        self.editing.roomCategory = val;
                    }
                });
            },
            template: tpl
        });
});
