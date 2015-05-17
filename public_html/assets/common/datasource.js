define(['knockout-es5', 'app/app'], function (ko, app) {
    var client = app.rest;
    var datasource = function (entity, columns, filter = {}, limit = -1, offset = -1, primaryKey = 'id') {
        var self            = this;
        this.client         = client;
        this.entity         = entity;
        this.columns        = columns;
        this.items          = [];
        this.count          = 0;
        this.filter         = filter;
        this.orderBy        = null;
        this.orderDesc      = false;
        this.limit          = limit;
        this.offset         = offset;
        this.primaryKey     = primaryKey;
        this.updateSchedule = null;
        this.isUpdating     = false;

        ko.track(this, ['items', 'count', 'filter', 'orderBy', 'orderDesc', 'offset', 'limit', 'isUpdating']);

        this.updateImmediately = function () {
            self.isUpdating = true;
            self.client.count(self.entity, self.filter, function (result) {
                self.count = result;
                if (result > 0) {
                    self.client.find(self.entity,
                                     self.filter,
                                     function (result) {
                                        self.items = result;
                                        self.isUpdating = false;
                                     },
                                     self.limit,
                                     self.offset,
                                     self.orderBy,
                                     self.orderDesc);
                } else {
                    self.items = [];
                    self.isUpdating = false;
                }
            });
        };

        this.update = function () {
            if (self.updateSchedule) {
                clearTimeout(self.updateSchedule);
            }
            self.updateSchedule = setTimeout(function () {
                self.updateImmediately();
            },
            250);
        };

        this.delete = function (id) {
            self.isUpdating = true;
            self.client.delete(self.entity,
                               id,
                               function (result) {
                                   self.updateImmediately();
                               });
        };

        ko.getObservable(this, 'filter').subscribe(function (val) {
            self.update();
        });
        ko.getObservable(this, 'offset').subscribe(function (val) {
            self.update();
        });
        ko.getObservable(this, 'limit').subscribe(function (val) {
            self.update();
        });
        ko.getObservable(this, 'orderBy').subscribe(function (val) {
            self.update();
        });
        ko.getObservable(this, 'orderDesc').subscribe(function (val) {
            self.update();
        });

        this.update();
        
    };
    return datasource;
});
