HistoryWiki.EditVM = function (article, formElement, createMode) {
    var self                    = this;
    this.form                   = formElement;
    this.createMode             = createMode;
    this.nameChangeNotifyState  = false;
    this.preview                = ko.observable('');
    this.previewIsLoading       = ko.observable(false);
    this.previewElement         = document.getElementById('article-preview');
    if (article.date && article.date.length > 10) {
        article.date = article.date.substr(0,10); // ISO-8601 date cut
    }
    if (article.eventDate && article.eventDate.length > 10) {
        article.eventDate = article.eventDate.substr(0,10); // ISO-8601 date cut
    }
    this.article = {
        type:       ko.observable(article.type),
        name:       ko.observable(article.name),
        content:    ko.observable(article.content),
        date:       ko.observable(article.date),
        eventDate:  ko.observable(article.eventDate)
    };
    this.serialized = ko.computed(function () {
        return JSON.stringify(ko.mapping.toJS(self.article));
    });

    this.updatePreview = function () {
        self.previewIsLoading(true);
        if (self.article.name() == null || self.article.name() == '') {
            alert('Введите имя статьи!');
            return;
        }
        var url = HistoryWiki.getService('preview');
        var formData = new FormData();
        formData.append('article', self.serialized());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.responseType = 'text'; //IE workaround
        xhr.onload = function(e) {
            if (this.status == 200) {
                self.preview(JSON.parse(this.response).data.content);
                HistoryWiki.formatArticle(self.previewElement);
                self.previewIsLoading(false);
            }
        };
        xhr.send(formData);
    };

    this.uploads = function () {
        if (self.article.name() == null || self.article.name() == '') {
            alert('Введите имя статьи!');
            return;
        }
        var text = '';
        HistoryWiki.Uploads.Choose(self.article.name(), function(choice) {
            switch(choice.type) {
                case 'UploadImage':
                    text = '![' + choice.originalFilename + '](=F' + choice.id + ')';
                    break;
                default:
                    text = '[' + choice.originalFilename + '](=F' + choice.id + ')';
            };
            self.article.content(self.article.content() + "\n" + text);
        });
    };

    this.save = function () {
        self.form.submit();
    };

    if (this.createMode === false) {
        this.article.name.subscribe(function (newValue) {
            if ( ! self.nameChangeNotifyState) {
                alert('Изменение имени статьи приведет к созданию новой!')
                self.nameChangeNotifyState = true;
            }
        });
        this.updatePreview();
    }
};
