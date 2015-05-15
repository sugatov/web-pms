define(['app/app'], function (app) {
    var client = app.rest;
    var datasource = function (entity, columns, filter = {}, primaryKey = 'id') {
        var self = this;
        this.client = client;
        this.entity = entity;
        this.columns = columns;
        this.filter = filter;
        this.primaryKey = primaryKey;

        this.count = function(criteria, callback) {
            for (var property in self.filter) {
                if (self.filter.hasOwnProperty(property)) {
                    criteria[property] = self.filter[property];
                }
            }
            self.client.count(self.entity, criteria, callback);
        };

        /*this.list = function(callback, limit = null, offset = null, orderBy = null, desc = false) {
            self.client.list(self.entity,
                             callback,
                             limit,
                             offset,
                             orderBy,
                             desc);
        };*/

        this.list = function(callback, limit = null, offset = null, orderBy = null, desc = false) {
            self.find(callback,
                      {},
                      limit,
                      offset,
                      orderBy,
                      desc);
        };

        this.find = function(callback, criteria, limit = null, offset = null, orderBy = null, desc = false) {
            for (var property in self.filter) {
                if (self.filter.hasOwnProperty(property)) {
                    criteria[property] = self.filter[property];
                }
            }
            self.client.find(self.entity,
                             criteria,
                             callback,
                             limit,
                             offset,
                             orderBy,
                             desc);
        };
    };
    return datasource;
});
