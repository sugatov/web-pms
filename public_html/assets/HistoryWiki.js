HistoryWiki = {};

HistoryWiki.getURL = function (url, params) {
    var result = url;
    for (var key in params) {
        var reg = new RegExp(':' + key, 'g');
        var val = params[key];
        result = result.replace(reg, val);
    }
    return result;
};

HistoryWiki.getService = function (name) {
    var domEl = document.getElementById('HistoryWiki.Services');
    if ( ! domEl) {
        throw '#HistoryWiki.Services node is not found!';
    }
    var attribName = 'data-' + name;
    var attrib = domEl.attributes.getNamedItem(attribName);
    if (attrib != null) {
        return attrib.value;
    } else {
        throw 'Service not found!';
    }
};


// NOTE: jQuery dependency:
HistoryWiki.formatArticle = function (element) {
    if ( ! (element instanceof jQuery)) {
        element = jQuery(element);
    }
    element.find('h1,h2,h3,h4,h5,h6').addClass('ui header');
    element.find('img:even').addClass('ui small bordered left floated image')
    element.find('img:odd').addClass('ui small bordered right floated image')
    element.find('p img').each(function () {
        var img = jQuery(this);
        var parent = img.parent();
        img.insertBefore(parent);
    });
}
