define(
    ['jquery', 'core/ajax', 'core/notification', 'core/str', 'core/templates', 'core/url', 'core/modal_events', 'core/modal_factory'],
    function($, AJAX, NOTIFICATION, STR, TEMPLATES, URL, ModalEvents, ModalFactory) {
    return {
        debug: 1,
        /**
         * Apply rules to page.
         */
        applyRules: function(elementstohide, elementstoset) {
            if (this.debug) console.log('local_experience/main:applyRule(elementstohide, elementstoset)', elementstohide, elementstoset);
            elementstohide = elementstohide.split("\n");
            elementstoset = elementstoset.split("\n");
            elementstohide.forEach(function(item) {
                try {
                    $(item).css('display', 'none');
                } catch(e) {}
            });
            elementstoset.forEach(function(item) {
                try {
                    var pair = item.split('=');
                    if (pair.length == 2) {
                        $(pair[0]).val(pair[1]);
                    }
                } catch(e) {}
            });
        },
        /**
         * Let's inject a button to switch experience.
         */
        injectButton: function(level, rulesapplied) {
            if (this.debug) console.log('local_experience/main:injectButton(level, rulesapplied)', level, rulesapplied);
            this.injectCSS();
            STR.get_strings([
                    {'key' : 'advanced_options', component: 'local_experience' },
                ]).done(function(s) {
                    $('#page-wrapper>.navbar>ul:last-child').prepend(
                        $('<li>').addClass('nav-item').append(
                            $('<div>').attr('id', 'nav-local-experience-switch').css('padding-top', '8px;').append([
                                $('<span>').html(s[0] + ' '),
                                $('<label>').addClass('switch').append([
                                    $('<input>').attr('type', 'checkbox')
                                        .prop('checked', level == 1)
                                        .attr('onclick', 'var c = this; require([\'local_experience/main\'], function(m) { m.switchExperience($(c).prop(\'checked\')); });'),
                                    $('<span>').addClass('slider round' + (rulesapplied ? ' rulesapplied' : '')),
                                ]),
                            ]),
                        ),
                    );
                }
            ).fail(NOTIFICATION.exception);
        },
        /**
         * Ensure we load specific CSS code.
         */
        injectCSS: function() {
            if ($('head>link[href$="/local/experience/style/switch.css"]').length == 0) {
                console.log('Adding CSS File ', URL.relativeUrl('/local/experience/style/switch.css'));
                $('head').append($('<link rel="stylesheet" type="text/css" href="' + URL.relativeUrl('/local/experience/style/switch.css') + '">'));
            }
        },
        /**
         * Switch experience using ajax call.
         * After we got confirmation, reload the page.
         */
        switchExperience: function(level) {
            level = (level) ? 1 : 0;
            var MAIN = this;
            console.log('local_experience/main:switchExperience(level)', level);

            AJAX.call([{
                methodname: 'local_experience_switch',
                args: { 'level': level },
                done: function(result) {
                    if (result == 1) {
                        top.location.reload();
                    }
                },
                fail: NOTIFICATION.exception
            }]);
        },
    };
});
