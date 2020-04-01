define(
    ['jquery', 'core/ajax', 'core/notification', 'core/str', 'core/templates', 'core/url', 'core/modal_events', 'core/modal_factory'],
    function($, AJAX, NOTIFICATION, STR, TEMPLATES, URL, ModalEvents, ModalFactory) {
    return {
        debug: 1,
        /**
         * Apply rules to page.
         */
        applyRules: function(level, allrules) {
            var MAIN = this;
            if (MAIN.debug) console.log('local_experience/main:applyRule(level, allrules)', level, allrules);

            $('body').removeClass('local-experience-level-0').removeClass('local-experience-level-1').addClass('local-experience-level-' + level);
            allrules.forEach(function() {
                if (MAIN.debug) console.log('=> apply Rule', this);
                elementstoset = this.elementstoset.split("\n");
                elementstoset.forEach(function(item) {
                    try {
                        var pair = item.split('=');
                        if (pair.length == 2) {
                            if (typeof level !== 'undefined' && level == 0) {
                                $(pair[0]).val(pair[1]);
                            }
                        }
                    } catch(e) {}
                });
            });
        },
        /**
         * Let's inject a button to switch experience.
         */
        injectButton: function(level, containers) {
            if (typeof containers === 'undefined') containers = '#page-wrapper>.navbar>ul:last-child';
            if (this.debug) console.log('local_experience/main:injectButton(level, containers)', level, containers);
            STR.get_strings([
                    {'key' : 'advanced_options', component: 'local_experience' },
                ]).done(function(s) {
                    $(containers).prepend(
                        //$('<li>').addClass('nav-item').append(
                            $('<div>').attr('class', 'nav-local-experience-switch').append([
                                $('<span>').html(s[0] + ' '),
                                $('<label>').addClass('switch').append([
                                    $('<input>').attr('type', 'checkbox')
                                        //.prop('checked', level == 1)
                                        .attr('onclick', 'var c = this; require([\'local_experience/main\'], function(m) { m.switchExperience($(c).prop(\'checked\')); });'),
                                    $('<span>').addClass('slider round'),
                                ]),
                            ]),
                        //),
                    );
                    if (level == 1) {
                        // We don't use prop('checked') here, because some html elements may not yet be active!
                        // our modulechoose for example requires us to set the attribute itself!
                        $('.nav-local-experience-switch input').attr('checked', 'checked');
                    }

                }
            ).fail(NOTIFICATION.exception);
        },
        /**
         * Inject tutorial texts based on page id or other criteria.
         */
        injectText: function() {
            if (this.debug) console.log('local_experience/main:injectText()');
            var pageids = ['page-question-type-ddwtos', 'page-question-type-multianswer', 'page-question-type-wordselect'];
            var id = $('body').attr('id');
            if (pageids.indexOf(id) > -1) {
                AJAX.call([{
                    methodname: 'local_experience_injecttext',
                    args: { 'pageid': id },
                    done: function(result) {
                        if (typeof result.text !== 'undefined' && result.text != '') {
                            if (typeof result.appendto !== 'undefined' && result.appendto != '') {
                                $(result.prependto).append($('<p>').addClass('alert alert-info').html(result.text));
                            }
                            if (typeof result.prependto !== 'undefined' && result.prependto != '') {
                                $(result.prependto).prepend($('<p>').addClass('alert alert-info').html(result.text));
                            }
                        }
                    },
                    fail: NOTIFICATION.exception
                }]);
            }
        },
        /**
         * Switch experience using ajax call.
         * After we got confirmation, reload the page.
         */
        switchExperience: function(level) {
            console.log('local_experience/main:switchExperience(level)', level);
            $('.nav-local-experience-switch input').prop('checked', level);
            level = (level) ? 1 : 0;
            $('body').removeClass('local-experience-level-0').removeClass('local-experience-level-1').addClass('local-experience-level-' + level);
            var MAIN = this;

            AJAX.call([{
                methodname: 'local_experience_switch',
                args: { 'level': level },
                done: function(result) {
                    if (result == 1) {
                        // We need not do that.
                        //top.location.reload();
                    }
                },
                fail: NOTIFICATION.exception
            }]);
        },
    };
});
