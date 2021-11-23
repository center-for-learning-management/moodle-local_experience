<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_experience
 * @copyright  2020 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'UI-experience';
$string['privacy:metadata'] = 'This plugin does not store any personal data';

$string['access_denied'] = 'Access denied!';
$string['add_another_explevel'] = 'Add another experience level';
$string['advanced_options'] = 'Expert mode';
$string['advanced_options:description'] = 'All functions of this page are displayed in expert mode!';
$string['attachlevelselectto'] = 'Attach level selector to';
$string['attachlevelselectto:description'] = 'Specify all containers line by line, where the level attach selector should be added to. You can specify if the level-switch will be appended or prepended and if a label will be shown.<br /><br /><i>CSS-Selector|prepend or append|true or false';

$string['auto_set_completion_details'] = 'Automatically set completion details';
$string['auto_set_completion_details:description'] = 'If enabled, completion rules will be automatically set when a new resource or activity is created. In addition to this option, days have to configured to be above 0!';
$string['auto_set_completion_add_days'] = 'Offset in forms';
$string['auto_set_completion_add_days:description'] = 'Set the expected completion date in forms to x days in the future in forms. Will recommend manual completion.';
$string['auto_set_completion_add_days_dnd'] = 'Offset for DND Uploads';
$string['auto_set_completion_add_days_dnd:description'] = 'Set the expected completion date in forms to x days in the future for DND uploads. Will result in an automated completion.';

$string['conditions'] = 'Conditions';
$string['conditions:add'] = 'Add condition';
$string['conditions:description'] = 'Here you can specify the conditions when a rule has to be applied.';
$string['conditions:removenotice'] = 'Remove a line by setting "name" to an empty value.';
$string['conditions:patternparameters'] = 'Parameter patterns';
$string['conditions:patternscriptnames'] = 'Scriptname patterns';

$string['c_r'] = 'Relation conditions <=> rules';

$string['experience:cantrigger'] = 'Can trigger experience';

$string['injectquestion:stack:_ids'] = '0';
$string['injectquestion:stack:_fields'] = 'ans1type,ans1modelans,ans1mustverify,defaultmark,generalfeedbackeditable,name,penalty,prt1answertest_0,prt1feedbackvariables,prt1sans_0,prt1tans_0,prt1truefeedback_0editable,prt1answertest_1,prt1sans_1,prt1tans_1,prt1truefeedback_1editable,prt1falsefeedback_1editable,prt1truescore_1,prt1falsescore_1,questionnote,questionvariables,questiontexteditable,specificfeedbackeditable,variantsselectionseed';

$string['injectquestion:stack:0:ans1type'] = 'checkbox';
$string['injectquestion:stack:0:ans1modelans'] = 'ta';
$string['injectquestion:stack:0:ans1mustverify'] = '0';
$string['injectquestion:stack:0:defaultmark'] = '1';
$string['injectquestion:stack:0:generalfeedbackeditable'] = '';
$string['injectquestion:stack:0:name'] = 'Template MC with feedback and subpoints';
$string['injectquestion:stack:0:penalty'] = '0.1';
$string['injectquestion:stack:0:prt1feedbackvariables'] = '
    ans2: makelist(if member(i,ans1) then 1 else 0, i,1,5);
    tans2: makelist(if member(i,tans1) then 1 else 0, i,1,5);
    counter: 0; list2:[]; for i:1 step 1 thru 5 do if ans2[i]=tans2[i] then counter:counter+1 else (counter:counter,push(i,list2));
    list2:sort(list2);
';
$string['injectquestion:stack:0:prt1answertest_0'] = 'AlgEquiv';
$string['injectquestion:stack:0:prt1sans_0'] = 'ans1';
$string['injectquestion:stack:0:prt1tans_0'] = 'tans1';
$string['injectquestion:stack:0:prt1truefeedback_0editable'] = '
    <p>Statement 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Statement 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Statement 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Statement 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Statement 5 {@ta[5][2]@}. <br> </p>
';
$string['injectquestion:stack:0:prt1answertest_1'] = 'AlgEquiv';
$string['injectquestion:stack:0:prt1sans_1'] = 'counter';
$string['injectquestion:stack:0:prt1tans_1'] = '4';
$string['injectquestion:stack:0:prt1truefeedback_1editable'] = '
    <p>Statement 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Statement 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Statement 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Statement 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Statement 5 {@ta[5][2]@}.</p>
    <p style="text-align: left;">There is one error in statement {@list2[1]@}. <br> </p>
';
$string['injectquestion:stack:0:prt1falsefeedback_1editable'] = '
    <p style="text-align: left;">Statement 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Statement 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Statement 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Statement 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Statement 5 {@ta[5][2]@}.</p>
    <p style="text-align: left;">Unfortunately there is more than one error, in total {@5-counter@} in the statements {@sort(list2)@}!! <br> </p>';
$string['injectquestion:stack:0:prt1truescore_1'] = '0.5';
$string['injectquestion:stack:0:prt1falsescore_1'] = '0';
$string['injectquestion:stack:0:questionnote'] = 'zufall';
$string['injectquestion:stack:0:questionvariables'] = '
    /*ai stands for ite statement, vi stands for iter bsteht für iter truth value, fbi stands for ites feedback.
    If there ins only one statement, the second entry of txti can be removed, vi can be directly set to true or false! */
    txt1: [ " Statement 1A", " Statement 1B"];
    n1: rand_with_step(1,length(txt1),1);
    a1: txt1[n1];
    v1: if n1=1 then true else false;
    fb1: "";

    txt2: [ " Statement 2A", " Statement 2B"];
    n2: rand_with_step(1,length(txt2),1);
    a2: txt2[n2];
    v2: if n2=1 then true else false;
    fb2: "";

    txt3: [ " Statement 3A", " Statement 3B"];
    n3: rand_with_step(1,length(txt3),1);
    a3: txt3[n3];
    v3: if n3=1 then true else false;
    fb3: "";


    txt4: [ " Statement 4A", " Statement 4B"];
    n4: rand_with_step(1,length(txt4),1);
    a4: txt4[n4];
    v4: if n4=1 then true else false;
    fb4: "";

    txt5: [ " Statement 5A", " Statement 5B"];
    n5: rand_with_step(1,length(txt5),1);
    a5: txt5[n5];
    v5: if n5=1 then true else false;
    fb5: "";


    txt6: [ " Statement 6A", " Statement 6B"];
    n6: rand_with_step(1,length(txt6),1);
    a6: txt6[n6];
    v6: if n6=1 then true else false;
    fb6: "";


    txt7: [ " Statement 7A", " Statement 7B"];
    n7: rand_with_step(1,length(txt7),1);
    a7: txt7[n7];
    v7: if n7=1 then true else false;
    fb7: "";

    txt8: [ " Statement 8A", " Statement 8B"];
    n8: rand_with_step(1,length(txt8),1);
    a8: txt8[n8];
    v8: if n8=1 then true else false;
    fb8: "";

    /* This list must be appended or shortened according to the amount of statements. */
    aussagen: [a1,a2,a3,a4,a5,a6,a7,a8];
    solutions: [v1,v2,v3,v4,v5,v6,v7,v8];
    feedback: [fb1,fb2,fb3,fb4,fb5,fb6,fb7,fb8];

    /* Selection of questions. From here on you must not change anything!*/
    k1: rand_with_step(1, length(aussagen),1);
    k2: rand_with_prohib(1,length(aussagen),[k1]);
    k3: rand_with_prohib(1,length(aussagen),[k1,k2]);
    k4: rand_with_prohib(1,length(aussagen),[k1,k2,k3]);
    alt: if solutions[k1]=false and solutions[k2]=false and solutions[k3]=false and solutions[k4]=false then true else false;
    ta: [[1,solutions[k1],sconcat(" 1: ",aussagen[k1])],[2,solutions[k2],sconcat(" 2: ",aussagen[k2])],[3,solutions[k3],sconcat(" 3: ",aussagen[k3])],[4,solutions[k4],sconcat(" 4: ",aussagen[k4])],[5, alt," 5: None of the statements is correct."]];
    fb: [feedback[k1],feedback[k2],feedback[k3],feedback[k4]]
    tans1: mcq_correct(ta);
';
$string['injectquestion:stack:0:questiontexteditable'] = '
    <p></p>
    <p>Please check the correct statements:</p>
    <p>[[input:ans1]] [[validation:ans1]]</p>
    <p>{@tans1@}</p>
    <p style="font-size:0.6em;text-align:right;">Created by: (yourname)</p>
';
$string['injectquestion:stack:0:specificfeedbackeditable'] = '[[feedback:prt1]]';
$string['injectquestion:stack:0:variantsselectionseed'] = '';




$string['injecttext:page-question-type-multianswer'] = '<p>Embedded answers (Cloze) questions consist of a passage of text (in Moodle format) that has various answers embedded within it, including multiple choice, short answers and numerical answers.</p>
    <p>The structure of each cloze sub-question is identical:</p>
    <p style="margin-left: 40px;">
        { start the cloze sub-question with a bracket (AltGr+7)<br />
        1 define a grade for each cloze by a number (optional). This used for calculation of question grading.<br />
        :SHORTANSWER: define the type of cloze sub-question. Definition is bounded by \':\'. <br />
        ~ is a seperator between answer options<br />
        = marks a correct answer<br />
        # marks the beginning of an (optional) feedback message<br />
        } close the cloze sub-question at the end with a bracket (AltGr+0)<br />
    </p>
    <p>Now a very simple example:</p>
    <p style="margin-left: 40px;">{1:SHORTANSWER:=Berlin} is the capital of Germany.</p>
    <a href="https://docs.moodle.org/38/en/Embedded_Answers_(Cloze)_question_type" target="_blank">read more</a>
    ';
$string['injecttext:page-question-type-ddwtos'] = '
    <p>Add the question to the text editor, using any formatting you wish. Use double square brackets \'[[n]]\' with a number in place of the word you wish the students to find.</p>
    <a href="https://docs.moodle.org/38/en/Drag_and_drop_into_text_question_type" target="_blank">read more</a>
    ';
$string['injecttext:page-question-type-stack'] = '
    <p>Please find more information about the STACK question type at the <a href="https://docs.moodle.org/311/en/STACK_question_type" target="_blank">Moodle Docs</a>.</p>
    <p>We prepared a template question for you, that you can enable simply by clicking on <a href="#" onclick="require([\'local_experience/main\'], function(M) { M.injectQuestionTemplate(\'stack\', 0) }); return false;" class="btn btn-secondary"><i class="fa fa-plus-circle"></i> insert template for MC with feedback and subpoints</a></p>
    ';
$string['injecttext:page-question-type-wordselect'] = '
    <p>This question type is designed to ask students to select text according to some criteria. For example "select the verb in the following sentence". Conceptually this is a little like a multiple choice question type (with multiple selectable options). The student responds by clicking on words to select them, and clicking a second time to unselect them.</p>
    <p>It provides an introduction field where words will not be selectable at runtime and a questiontext field. In the question text any words with braces around them will be considered correct. All words can be clicked-on to select.</p>
    <a href="https://docs.moodle.org/38/en/Wordselect_question_type" target="_blank">read more</a>
    ';
$string['injecttext:page-mod-bigbluebuttonbn-mod'] = 'The <a href="https://www.lernmanagement.at" target="_blank">Center for Learning Management</a> provides the open source video conferencing software <a href="https://bigbluebutton.org" target="_blank">BigBlueButton</a> in a basic version for up to 1000 simultaneous users. BBB tariffs with higher or guaranteed bandwidth can be obtained from various providers for a fee.';
$string['injecttext:page-mod-bigbluebuttonbn-mod:readmore'] = '[<a href="{$a->wwwroot}/local/experience/pages/bigbluebutton.php" target="_blank">learn more</a>]';
$string['injecttext:page-mod-bigbluebuttonbn-mod:longtext'] = '<p>In order to be able to quickly switch to a more powerful, chargeable BBB server in the event of a crisis, we have put together 3 providers as examples. If an external service provider is chosen, a contract must be concluded between the provider and the school. In Eduvidual an alternative BBB server can be entered for each school individually via the management interface. If you have any questions please contact <a href="mailto:rene.schwarzinger@lernmanagement.at?subject=BigBlueButton">rene.schwarzinger@lernmanagement.at</a>!</p>

<p>These offers were compiled in September 2020 as an example. Please contact the providers directly for the current prices and conditions.</p>

<h4>meet-modular</h4>
<p>Minimum term 3 months<br />
1 class average a 25 students according to the fair use principle<br />
Package up to 12 classes: 149 € (per month excl. VAT)<br />
Package up to 24 classes: 249 €<br />
Package up to 60 classes: 349 €<br />
Server location: Germany<br />
Contact: info@think-modular.com</p>

<h4>OpenFabNet</h4>
<p>Minimum term 1 month<br />
Costs: 1€ / per month / simultaneous user according to shared host principle (no VAT)<br />
Server location: Austria<br />
Contact: christian.schwarzinger@openfab.org</p>

<h4>Big Blue Meeting</h4>
<p>shared BBB hosting or managed dedicated BBB hosting<br />
https://www.bigbluemeeting.com/</p>';

$string['pluginname:settings'] = 'UI-experience settings';

$string['rules'] = 'Rules';
$string['rules:add'] = 'Add rule';
$string['rules:description'] = 'Here you can specify how the forms should be modified for the beginner level. Enter the type of activity/resource. Name all elements that should be hidden line by line. Do the same for default values, but use the syntax my_css_selector1=my_default_value1\n my_css_selector2=my_default_value2 and so on.';
$string['rules:elementstohide'] = 'Hide Elements with the following selectors';
$string['rules:elementstoset'] = 'Set form fields to the following values';
$string['rules:removenotice'] = 'Remove a line by setting "name" to an empty value.';
