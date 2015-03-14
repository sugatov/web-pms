HistoryWiki.EditVM = function (article, formElement, createMode) {
    var self                    = this;
    this.form                   = formElement;
    this.createMode             = createMode;
    this.nameChangeNotifyState  = false;
    this.preview                = ko.observable('');
    this.previewIsLoading       = ko.observable(false);
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
        jQuery.ajax({
            cache: false,
            data: {article: self.serialized()},
            type: 'post',
            url: '/preview',
            success: function(response) {
                self.preview(response.data.content);
                self.previewIsLoading(false);
            }
        });
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
