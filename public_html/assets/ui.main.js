document.addEventListener("DOMContentLoaded", function (event) {
    var searchSubmitButton = document.getElementById('menu-search-submit');
    searchSubmitButton.addEventListener('click', function() {
        var searchForm = document.getElementById('menu-search-form');
        if (Modernizr.input.required) {
            if ( ! searchForm.checkValidity()) {
                return false;
            }
        } else {
            var searchInput = document.getElementById('menu-search-input');
            if (searchInput.value.length < 1) {
                return false;
            }
        }
        searchForm.submit();
        return true;
    });

    // NOTE: jQuery dependency
    jQuery('.tabular.menu .item').tab();
});
