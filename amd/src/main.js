define(
    ['jquery', 'core/ajax', 'core/notification', 'core/str', 'core/templates', 'core/url', 'core/modal_events', 'core/modal_factory'],
    function($, AJAX, NOTIFICATION, STR, TEMPLATES, URL, ModalEvents, ModalFactory) {
    return {
        debug: 1,
        rules: [],
        sets: [],
        origdisplay: {},
        origvalue: {},
        tmpvalue: {},
        /**
         * Apply rules to page.
         */
        applyRules: function(rulename, level, elementstohide, elementstoset) {
            var MAIN = this;
            elementstohide = elementstohide.split("\n");
            elementstoset = elementstoset.split("\n");
            if (MAIN.debug) console.log('local_experience/main:applyRule(rulename, level, elementstohide, elementstoset, rulename)', rulename, level, elementstohide, elementstoset);
            $('body').removeClass('local-experience-level-0').removeClass('local-experience-level-1').addClass('local-experience-level-' + level);
            /*
            elementstohide.forEach(function(item) {
                try {
                    MAIN.rules[MAIN.rules.length] = item;
                    MAIN.origdisplay[item] = $(item).css('display');
                    if (typeof level !== 'undefined' && level == 0) {
                        $(item).css('display', 'none');
                    }
                } catch(e) {}
            });
            */
            elementstoset.forEach(function(item) {
                try {
                    var pair = item.split('=');
                    if (pair.length == 2) {
                        MAIN.sets[MAIN.sets.length] = pair;
                        MAIN.origvalue[pair[0]] = $(pair[0]).val();
                        if (typeof level !== 'undefined' && level == 0) {
                            $(pair[0]).val(pair[1]);
                        }
                    }
                } catch(e) {}
            });
        },
        /**
         * Apply all rules again.
         */
        applyRedo: function() {
            var MAIN = this;
            MAIN.rules.forEach(function(rule) {
                $(rule).css('display', 'none');
            });
            MAIN.sets.forEach(function(pair) {
                if (typeof MAIN.tmpvalue[pair[0]] !== 'undefined') {
                    $(pair[0]).val(MAIN.tmpvalue[pair[0]]);
                } else {
                    $(pair[0]).val(pair[1]);
                }
            });
        },
        /**
         * Undo all rules.
         */
        applyUndo: function() {
            var MAIN = this;
            var ids = Object.keys(MAIN.origdisplay);
            ids.forEach(function(id) {
                $(id).css('display', MAIN.origdisplay[id]);
            });
            var vs = Object.keys(MAIN.origvalues);
            vs.forEach(function(v) {
                MAIN.tmpvalue[v] = $(v).val();
                $(v).val(MAIN.origvalues[v]);
            });
        },
        /**
         * Let's inject a button to switch experience.
         */
        injectButton: function(level, rulesapplied, containers) {
            if (typeof rulesapplied === 'undefined') rulesapplied = 0;
            if (typeof containers === 'undefined') containers = '#page-wrapper>.navbar>ul:last-child';
            if (this.debug) console.log('local_experience/main:injectButton(level, rulesapplied, containers)', level, rulesapplied, containers);
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
                                    $('<span>').addClass('slider round' + (rulesapplied == 1 ? ' rulesapplied' : '')),
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
            var pageids = ['page-question-type-multianswer'];
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
                    if (level == 1) {
                        MAIN.applyUndo();
                    } else {
                        MAIN.applyRedo();
                    }
                    if (result == 1) {
                        //top.location.reload();
                    }
                },
                fail: NOTIFICATION.exception
            }]);
        },
    };
});
