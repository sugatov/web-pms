define(['knockout-es5', 'text!./confirmation-dialog.html', 'node-uuid', 'jquery', 'knockout-jqueryui/dialog'], function(ko, tpl, uuid, $) {
    ko.components.register('confirmation-dialog', {
        viewModel: {
            createViewModel: function (params, componentInfo) {
                var vm = function (params, componentInfo) {
                    var self     = this;
                    this.element = componentInfo.element;
                    this.uuid    = uuid.v1();
                    this.message = params.message;
                    ko.track(this);
                    // $(this.element).find('.ui.modal').modal('show');
                    // $(this.element).find('.ui.modal').modal('show');
                    // console.log($(this.element));
                    $(this.element).dialog({
                        buttons: [
                            {
                                text: 'Да',
                                click: function () {}
                            },
                            {
                                text: 'Нет',
                                click: function () {}
                            }
                        ]
                    });
                };

                return new vm(params, componentInfo);
            }
        },
        template: tpl
    });
});
