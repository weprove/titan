/**
 * AJAX Nette Framwork plugin for jQuery
 *
 * @copyright   Copyright (c) 2009 Jan Marek
 * @license     MIT
 * @link        http://nettephp.com/cs/extras/jquery-ajax
 * @version     0.2
 */

jQuery.extend({
	nette: {
		updateSnippet: function (id, html) {
			$("#" + id).html(html);
		},

		success: function (payload) {
			// redirect
			if (payload.redirect) {
				window.location.href = payload.redirect;
				return;
			}

			// snippets
			if (payload.snippets) {
				for (var i in payload.snippets) {
					jQuery.nette.updateSnippet(i, payload.snippets[i]);
				}
			}
		}
	}
});

jQuery.ajaxSetup({
	success: jQuery.nette.success,
	dataType: "json"
});

// zajaxovatění odkazů provedu takto
$("a.ajax").on("click", function (event) {
    event.preventDefault();

    $.get(this.href);

    // zobrazení spinneru a nastavení jeho pozice
    $("#ajax-spinner").show().css({
        position: "absolute",
        left: event.pageX + 20,
        top: event.pageY + 40
    });
});

/* AJAXové odeslání formulářů */
/*$("form.ajax").live("submit", function () {
    $(this).ajaxSubmit();
    return false;
});

$("form.ajax :submit").live("click", function () {
    $(this).ajaxSubmit();
    return false;
});*/
