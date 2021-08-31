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
            allrules.forEach(function(rule) {
                if (MAIN.debug) console.log('=> apply Rule', rule);
                elementstoset = rule.elementstoset.split("\n");split("\n
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
         * Detect certain keyCodes and do according action.
         */
        captureKeycode: function() {
            document.addEventListener ("keydown", function (e) {
                //console.log('pressed any key', e.key, e);
                // e.ctrlKey, e.altKey, e.shiftKey, e.metaKey
                if (e.altKey && e.shiftKey && e.keyCode == 69) {
                    //console.log('Pressed edit key', e);
                    AJAX.call([{
                        methodname: 'local_experience_keycode',
                        args: { 'action': 'editmode' },
                        done: function(result) {
                            //console.log('Result is ', result);
                            location.reload();
                        },
                        fail: NOTIFICATION.exception
                    }]);
                }
            } );
        },
        /**
         * Detect if anything on this site is/could be modified and color our switches accordingly.
         */
        detectModification: function() {
            var mod = false;
            // List of identifiers that would be changed.
            ['#activity-settings-modulesettings',
             'body #course-settings-courseadmin',
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
        enablePanelTrigger: function(level) {
            var MAIN = this;
            if (MAIN.debug) console.log('local_experience/main:enablePanelTrigger(level)', level);
            var panelEntry = $('#nav-drawer a[data-key="experiencelevel"]')
                .addClass('nav-local-experience-btn')
                .attr('onclick', "var c = this; require(['local_experience/main'], function(m) { m.switchExperience(!$(c).hasClass('experience-advanced')); }); return false;");
            var mediaLeft = panelEntry.find('.media-left');
            if (level == 1) {
                panelEntry.addClass('experience-advanced')
                mediaLeft.html('<i class="fa fa-icon fa-toggle-on" style="font-size: 18px;"></i>');
            } else {
                mediaLeft.html('<i class="fa fa-icon fa-toggle-off" style="font-size: 18px;"></i>');
            }
        },
        /**
         * Inject tutorial texts based on page id or other criteria.
         */
        injectText: function() {
            if (this.debug) console.log('local_experience/main:injectText()');
            var pageids = ['page-question-type-ddwtos',
                           'page-question-type-multianswer',
                           'page-question-type-wordselect',
                           'page-mod-bigbluebuttonbn-mod'];
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
