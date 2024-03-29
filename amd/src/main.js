define(
    ['jquery', 'core/ajax', 'core/config', 'core/notification', 'core/str', 'core/templates', 'core/url', 'core/modal_events', 'core/modal_factory'],
    function($, AJAX, CFG, NOTIFICATION, STR, TEMPLATES, URL, ModalEvents, ModalFactory) {
    return {
        debug: false,
        /**
         * Apply rules to page.
         */
        applyRules: function(level, allrules) {
            var MAIN = this;
            if (MAIN.debug) console.log('local_experience/main:applyRule(level, allrules)', level, allrules);

            $('body').removeClass('local-experience-level-0').removeClass('local-experience-level-1').addClass('local-experience-level-' + level);
            allrules.forEach(function(rule) {
                if (MAIN.debug) console.log('=> apply Rule', rule);
                elementstoset = rule.elementstoset.split("\n");
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
         * Add an overlay to prevent user interaction.
         */
        injectOverlayAdd: function() {
            if ($('#local_experience_injectquestion_overlay').length > 0) return;

            TEMPLATES.render('local_experience/overlay', {})
                .done(function(html, js) {
                    TEMPLATES.appendNodeContents('body', html, js);
                }).fail(NOTIFICATION.exception);
        },
        /**
         * Remove the overlay that prevents user interaction.
         */
        injectOverlayRemove: function() {
            $('#local_experience_injectquestion_overlay').remove();
        },
        /**
         * Inject the template of a particular question.
         * @param qtype question type.
         * @param tid template id.
         * @param post_exec lang string that contains javascript to be executed.
         */
        injectQuestionTemplate: function(qtype, tid, post_exec) {
            tid = parseInt(tid);
            if (typeof(post_exec) === 'undefined') post_exec = 'post_exec_0';
            if (this.debug) console.log('local_experience/main::injectQuestionTemplate(qtype, tid, post_exec)', qtype, tid, post_exec);
            var M = this;
            if (qtype == 'stack') {
                var x = post_exec.split('_');
                var post_exec_id = parseInt(x[x.length-1]);
                $('#id_prt1nodeadd').closest('form').append(
                    $('<input type="hidden" name="local_experience_injectquestion" value="stack:' + tid + ':post_exec_' + (post_exec_id + 1) + '" />')
                );
                M.injectOverlayAdd();
                var metastrs = [
                    { 'key': 'injectquestion:stack:_ids', 'component': 'local_experience' },
                    { 'key': 'injectquestion:stack:_fields', 'component': 'local_experience' },
                ];
                if (M.debug) console.log('metastrs', metastrs);

                STR.get_strings(metastrs).done(
                    function(meta_s) {
                        var ids = $.map(meta_s[0].split(','), Number);
                        var strs = meta_s[1].split(',');

                        if (M.debug) console.log('valid ids are ', ids);

                        if (ids.indexOf(tid) == -1) {
                            alert('Invalid template id');
                            return;
                        }
                        var getstrs = [];

                        strs.forEach(function(qkey) {
                            getstrs.push({'key' : 'injectquestion:stack:' + tid + ':' + qkey, 'component': 'local_experience' });
                        });

                        if (M.debug) console.log('getstrs', getstrs);
                        STR.get_strings(getstrs).done(
                            function(s) {
                                var post_exec_str = '';
                                getstrs.forEach(function(keyitem,index) {
                                    var key = keyitem.key;
                                    var fkey = strs[index];
                                    var val = s[index];
                                    if (fkey.substring(0, 10) == 'post_exec_') {
                                        if (fkey == post_exec) {
                                            post_exec_str = val;
                                        }
                                        return; // means "continue"
                                    }
                                    var targid = 'form[action="question.php"] #id_' + fkey;
                                    var target = $(targid);
                                    if (target.is("select")) {
                                        $(targid + ' option[selected]').removeAttr('selected');
                                        if (M.debug) console.log('set ' + targid + ' option[value="' + val + '"] to selected');
                                        $(targid + ' option[value="' + val + '"]')
                                            .attr('selected', 'selected')
                                            .prop('selected', true);
                                    } else if (target.is('textarea') || target.is('div')) {
                                        if (M.debug) console.log('set ' + targid + ' to ', val);
                                        $(target).html(val.trim());
                                    } else if (target.is("[type=checkbox]")) {
                                        if (M.debug) console.log('set ' + targid + ' to ', val);
                                        $(target).prop('checked', (val == 1));
                                    } else {
                                        if (M.debug) console.log('set ' + targid + ' to ', val);
                                        target.val(val);
                                    }

                                    if (target.is("[role=textbox]")) {
                                        var subtargid = targid.substring(0, targid.length - 'editable'.length);
                                        console.log('Setting subtargid ', subtargid);
                                        $(subtargid).html(val.trim());
                                    }
                                });
                                if (post_exec_str != '') {
                                    eval(post_exec_str);
                                } else {
                                    M.injectOverlayRemove();
                                }
                            }
                        ).fail(NOTIFICATION.exception);
                    }
                ).fail(NOTIFICATION.exception);
            }
        },
        /**
         * Inject tutorial texts based on page id or other criteria.
         */
        injectText: function() {
            if (this.debug) console.log('local_experience/main:injectText()');
            var pageids = ['page-question-type-ddwtos',
                           'page-question-type-multianswer',
                           'page-question-type-stack',
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
         * Set the completion date to and completion to manual.
         * @param daysplus how many days in future should be the default completion date.
         */
        setCompletionDefaults: function(daysplus) {
            if (this.debug) console.log('local_experience/main:setCompletionDefaults(daysplus)', daysplus);
            $('#region-main #id_completion').val(1).change();
            $('#region-main #id_completionexpected_enabled').prop('checked', true);

            var d = new Date();
            d.setDate(d.getDate() + parseInt(daysplus));

            $('#region-main #id_completionexpected_day').val(d.getDate()).change();
            $('#region-main #id_completionexpected_month').val(d.getMonth()+1).change();
            $('#region-main #id_completionexpected_year').val(d.getFullYear()).change();
            $('#region-main #id_completionexpected_hour').val(d.getHours()).change();
            $('#region-main #id_completionexpected_minute').val(d.getMinutes()).change();
        },

        /**
         * Switch experience using ajax call.
         * After we got confirmation, reload the page.
         */
        switchExperience: function(level) {
            if (this.debug) console.log('local_experience/main:switchExperience(level)', level);
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
