
function plugin_secret_toggle(element) {
    if (element.style.display !== "none") {
        jQuery(element).hide();
        return 0; // print show text
    } else {
        jQuery(element).show();
        return 1; // print hide text
    }
}

function plugin_secret_action(element) {
    var j_parent = jQuery(element.parentNode);
    var j_element = jQuery(element);

    var title = j_element.children('span.title_text')[0];
    var body = j_parent.children('div.hidden_solution_contents')[0];

    console.warn(title);

    var hide_text = j_parent.children('div.hide_text')[0].innerHTML;
    var show_text = j_parent.children('div.show_text')[0].innerHTML;

    var state = plugin_secret_toggle(body, hide_text, show_text);
    if (state == 0) {
        title.innerHTML = show_text;
    } else if (state == 1) {
        title.innerHTML = hide_text;
    } else {
        console.warn('Unknown state');
    }
}

function attachEvents() {
    jQuery(".hidden_solution_contents").each(
        function() {
            plugin_secret_toggle(this);
        });

    jQuery(".hidden_solution_title").each(
        function() {
            jQuery(this).click(
                function() {
                    plugin_secret_action(this);
                });
        });
}

jQuery(function(){attachEvents();});
