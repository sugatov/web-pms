jQuery(document).ready(function(){
    jQuery('.ui.sticky').sticky();
    jQuery('.ui.dropdown').dropdown();
    jQuery('.ui.checkbox').each(function(index, checkbox){
        var domEl = jQuery(checkbox);
        var input = domEl.find('input[type=checkbox]');
        if (input.attr('checked') === 'checked') {
            domEl.checkbox('enable');
        } else {
            domEl.checkbox('disable');
        }
    });
});

