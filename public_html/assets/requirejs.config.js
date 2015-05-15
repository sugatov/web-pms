require.config({
    baseUrl: '/assets',
    paths: {
        "text" : "bower_components/requirejs-text/text",
        "jquery": "bower_components/jquery/dist/jquery",
        "jquery-ui": "bower_components/jquery-ui/ui",
        "knockout": "bower_components/knockout/dist/knockout.debug",
        "knockout-es5": "bower_components/knockout-es5/dist/knockout-es5",
        "knockout-mapping": "bower_components/knockout-mapping/knockout.mapping",
        "knockout-jqueryui": "bower_components/knockout-jqueryui/dist/amd",
        "less": "bower_components/less.js/dist/less",
        "modernizr": "bower_components/modernizr/modernizr",
        "requirejs": "bower_components/requirejs/require",
        "semantic-ui": "bower_components/semantic-ui/dist/semantic"
    },
    shim: {
        'semantic-ui': {
            deps: ["jquery"],
            // Export multiple functions: http://stackoverflow.com/a/18650150/14731
            exports: "$",
            init: function ($) {
                return {
                    "$.fn.accordion": $.fn.accordion,
                    "$.fn.accordion.settings": $.fn.accordion.settings,
                    "$.fn.form": $.fn.form,
                    "$.fn.form.settings": $.fn.form.settings,
                    "$.fn.state": $.fn.state,
                    "$.fn.state.settings": $.fn.state.settings,
                    "$.fn.checkbox": $.fn.checkbox,
                    "$.fn.checkbox.settings": $.fn.checkbox.settings,
                    "$.fn.dimmer": $.fn.dimmer,
                    "$.fn.dimmer.settings": $.fn.dimmer.settings,
                    "$.fn.dropdown": $.fn.dropdown,
                    "$.fn.dropdown.settings": $.fn.dropdown.settings,
                    "$.fn.modal": $.fn.modal,
                    "$.fn.modal.settings": $.fn.modal.settings,
                    "$.fn.nag": $.fn.nag,
                    "$.fn.nag.settings": $.fn.nag.settings,
                    "$.fn.popup": $.fn.popup,
                    "$.fn.popup.settings": $.fn.popup.settings,
                    "$.fn.rating": $.fn.rating,
                    "$.fn.rating.settings": $.fn.rating.settings,
                    "$.fn.search": $.fn.search,
                    "$.fn.search.settings": $.fn.search.settings,
                    "$.fn.shape": $.fn.shape,
                    "$.fn.shape.settings": $.fn.shape.settings,
                    "$.fn.sidebar": $.fn.sidebar,
                    "$.fn.sidebar.settings": $.fn.sidebar.settings,
                    "$.fn.tab": $.fn.tab,
                    "$.fn.tab.settings": $.fn.tab.settings,
                    "$.fn.transition": $.fn.transition,
                    "$.fn.transition.settings": $.fn.transition.settings,
                    "$.fn.video": $.fn.video,
                    "$.fn.video.settings": $.fn.video.settings
                };
            }
        }
    }
});
