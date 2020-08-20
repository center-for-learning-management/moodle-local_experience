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
         * Detect if anything on this site is/could be modified and color our switches accordingly.
         */
        detectModification: function() {
            var mod = false;
            // List of identifiers that would be changed.
            ['#activity-settings-modulesettings',
             'body.pagelayout-incourse #course-settings-courseadmin',
             'body#page-question-type-multichoice',
             'form#add_block',
             'form#chooserform',
             'form[action="modedit.php"]',
             '.bcs-new-course.backup-section',
             '.bcs-existing-course.backup-section'].forEach(function(identifier) {
                if ($(identifier).length > 0) {
                    mod = true;
                }
            });
            if (mod) {
                $('.nav-local-experience-switch .slider').addClass('rulesapplied');
                $('.nav-local-experience-btn').addClass('rulesapplied');
                $('.local_experience_wrapper>div').addClass('rulesapplied');
            }
        },
        /**
         * THIS FUNCTION IS OBSOLETE, WHEN BUTTON IS INSERTED VIA lib.php:local_experience_before_standard_top_of_body_html()
         * Let's inject a button to switch experience.
         */
         /*
        injectButton: function(level, containers) {
            var MAIN = this;
            if (typeof containers === 'undefined') containers = '#page-wrapper>.navbar>ul:last-child';
            if (this.debug) console.log('local_experience/main:injectButton(level, containers)', level, containers);
            STR.get_strings([
                    {'key' : 'advanced_options', component: 'local_experience' },
                ]).done(function(s) {
                    var onclick = [
                        'var c = this;',
                        'require([\'local_experience/main\'], function(m) {',
                        '    m.switchExperience(!$(c).hasClass(\'experience-advanced\'));',
                        '});',
                        'return false;'
                    ].join('');
                    var navbtn = $('a[data-key="experiencelevel"]')
                        .attr('href', '#')
                        .addClass('nav-local-experience-btn')
                        .attr('onclick', onclick)
                        .css('padding-top', '12px');
                    if (level == 1) {
                        navbtn.find('.media-left').html('<i class="fa fa-icon fa-toggle-on"></i>');
                        navbtn.addClass('experience-advanced');
                    } else {
                        navbtn.find('.media-left').html('<i class="fa fa-icon fa-toggle-off"></i>');
                    }
                    var wrapper = $('<div id="local_experience_wrapper">')
                        .addClass('alert alert-info')
                        .css('position', 'fixed')
                        .css('bottom', '0px')
                        .css('left', '50%')
                        .css('padding-left', '-50%')
                        .css('height', '0px');

                    navbtn.closest('#nav-drawer').prepend($('<nav class="list-group">').append($('<ul>').append(navbtn.closest('li'))));

                    containers.split("\n").forEach(function(identifier) {
                        if ($(container).length == 0) {
                            return; // this is like "continue" in forEach-Loop.
                        }
                        // Set values based on identifier
                        var params = {};
                        var x = identifier.split('|');
                        var PID_IDENTIFIER = 0,
                            PID_APPEND = 1,
                            PID_LABEL = 2;
                        for (var a = 0; a <= 2; a++) {
                            if (typeof x[a] !== 'undefined') {
                                params[a] = x[a].trim();
                                switch (a) {
                                    case PID_LABEL: params[a] = (x[a].trim() == 'true'); break;
                                }
                            } else {
                                // No value given, set a default value.
                                params[a] = false;
                                switch (a) {
                                    case PID_APPEND: params[a] = 'append'; break;
                                    case PID_LABEL: params[a] = true; break;
                                }

                            }
                        }

                        var sw = $('<div>').attr('class', 'nav-local-experience-switch');
                        if (params[PID_LABEL] == true) {
                            sw.append($('<span>').html(s[0] + ' '));
                        }
                        sw.append($('<label>').addClass('switch').append([
                            $('<input>').attr('type', 'checkbox')
                                //.prop('checked', level == 1)
                                .attr('onclick', 'var c = this; require([\'local_experience/main\'], function(m) { m.switchExperience($(c).prop(\'checked\')); });'),
                            $('<span>').addClass('slider round'),
                        ]));
                        var container = $(params[PID_IDENTIFIER]);
                        // Check if we need to wrap our switch based on the container.
                        if ($(container).is('ul') || $(container).is('ol')) {
                            sw = $('<li>').append(sw);
                        }
                        if (params[PID_APPEND] == 'prepend') {
                            $(params[PID_IDENTIFIER]).prepend(sw);
                        } else {
                            $(params[PID_IDENTIFIER]).append(sw);
                        }

                    });

                    if (level == 1) {
                        // We don't use prop('checked') here, because some html elements may not yet be active!
                        // our modulechoose for example requires us to set the attribute itself!
                        $('.nav-local-experience-switch input').attr('checked', 'checked');
                    }

                    MAIN.detectModification();
                }
            ).fail(NOTIFICATION.exception);
        },
        */
        /**
         * Inject tutorial texts based on page id or other criteria.
         */
        injectText: function() {
            if (this.debug) console.log('local_experience/main:injectText()');
            var pageids = ['page-question-type-ddwtos',
                           'page-question-type-multianswer',
                           'page-question-type-wordselect'];
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
            level = (level) ? 1 : 0;
            var navbtn = $('.nav-local-experience-btn');
            if (level == 1) {
                navbtn.addClass('experience-advanced');
                navbtn.find('.media-left i').removeClass('fa-toggle-off').addClass('fa-toggle-on');
            } else {
                navbtn.removeClass('experience-advanced');
                navbtn.find('.media-left i').removeClass('fa-toggle-on').addClass('fa-toggle-off');
            }

            //$('.nav-local-experience-switch input').prop('checked', level);

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
