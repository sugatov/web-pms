define(function () {
    return function (HTTPClient, baseURL) {
        var self = this;
        self.http = HTTPClient;
        self.baseURL = baseURL;

        self._getFindByURL = function (className, list = false, limit = null, offset = null, orderBy = null, desc = false) {
            var url = self.baseURL + '/' + className;
            if (list === true) {
                url += '/list';
            } else {
                url += '/find';
            }
            if (limit) {
                url += '/' + limit;
                if (offset) {
                    url += '/' + offset;
                    if (orderBy) {
                        url += '/' + orderBy;
                        if (desc === true) {
                            url += '/1';
                        }
                    }
                }
            }
            return url;
        }

        self.count = function(className, data, callback) {
            var url = self.baseURL + '/' + className + '/count';
            self.http.post(
                url,
                JSON.stringify(data),
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.list = function (className, callback, limit = null, offset = null, orderBy = null, desc = false) {
            var url = self._getFindByURL(className, true, limit, offset, orderBy, desc);
            self.http.get(
                url,
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.find = function (className, criteria, callback, limit = null, offset = null, orderBy = null, desc = false) {
            var url = self._getFindByURL(className, false, limit, offset, orderBy, desc);
            self.http.post(
                url,
                JSON.stringify(criteria),
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.getNew = function(className, callback) {
            var url = self.baseURL + '/' + className;
            self.http.get(
                url,
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.get = function(className, id, callback) {
            var url = self.baseURL + '/' + className + '/' + id;
            self.http.get(
                url,
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.put = function(className, id, data, callback) {
            var url = self.baseURL + '/' + className + '/' + id;
            self.http.put(
                url,
                JSON.stringify(data),
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.post = function(className, data, callback) {
            var url = self.baseURL + '/' + className;
            self.http.post(
                url,
                JSON.stringify(data),
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.delete = function(className, id, callback) {
            var url = self.baseURL + '/' + className + '/' + id;
            self.http.delete(
                url,
                null,
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };

        self.patch = function(className, id, data, callback) {
            var url = self.baseURL + '/' + className + '/' + id;
            self.http.patch(
                url,
                JSON.stringify(data),
                function (response) {
                    callback(response.data);
                },
                function (response) {
                    console.log(response);
                }
            );
        };
    };
});
