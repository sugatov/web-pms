define(['jquery'], function (jQuery) {
    var http = function () {
        var self = this;

        self.get = function (url, success, fail) {
            jQuery.ajax(url,
            {
                method: "GET"
            }).done(function (response) {
                success(response);
            }).fail(function (response) {
                fail(response);
            });
        };

        self.post = function (url, data, success, fail) {
            jQuery.ajax(url,
            {
                method: "POST",
                data: data
            }).done(function (response) {
                success(response);
            }).fail(function (response) {
                fail(response);
            });
        };

        self.put = function (url, data, success, fail) {
            jQuery.ajax(url,
            {
                method: "PUT",
                data: data
            }).done(function (response) {
                success(response);
            }).fail(function (response) {
                fail(response);
            });
        };

        self.delete = function (url, data, success, fail) {
            jQuery.ajax(url,
            {
                method: "DELETE",
                data: data
            }).done(function (response) {
                success(response);
            }).fail(function (response) {
                fail(response);
            });
        };

        self.patch = function (url, data, success, fail) {
            jQuery.ajax(url,
            {
                method: "PATCH",
                data: data
            }).done(function (response) {
                success(response);
            }).fail(function (response) {
                fail(response);
            });
        };
    };
    return new http();
});

