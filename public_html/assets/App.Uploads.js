App.Uploads = {};
App.Uploads.Choose = function (tag, callback) {
    self = this;
    self._callback = callback;
    page = 1;
    var url = App.getService('uploads');
    url = App.getURL(url, {page: page, tag: tag});
    if (self._window && ! self._window.closed) {
        self._window.focus();
    } else {
        self._window = window.open(
            url,
            'App.Uploads.Choose',
            'width=800,height=800,resizable=yes,scrollbars=yes,status=no,menubar=no,location=no,directories=no'
        );
    }
};

App.Uploads.ChooseCallback = function (data) {
    self = this;
    self._callback(data);
};
