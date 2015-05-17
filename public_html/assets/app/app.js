define(['./http', './rest'], function(http, rest) {
    var app = function () {
        var self = this;

        self.getURL = function (url, params) {
            var result = url;
            for (var key in params) {
                var reg = new RegExp(':' + key, 'g');
                var val = params[key];
                result = result.replace(reg, val);
            }
            return result;
        };

        self.getService = function (name) {
            var domEl = document.getElementById('App.Services');
            if ( ! domEl) {
                throw '#App.Services node is not found!';
            }
            var attribName = 'data-' + name;
            var attrib = domEl.attributes.getNamedItem(attribName);
            if (attrib != null) {
                return attrib.value;
            } else {
                throw 'Service not found!';
            }
        };

        self.http = http;
        self.rest = new rest(http, '/api/rest');
    };
    return new app();
});