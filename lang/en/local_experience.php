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

$string['conditions'] = 'Conditions';
$string['conditions:add'] = 'Add condition';
$string['conditions:description'] = 'Here you can specify the conditions when a rule has to be applied.';
$string['conditions:removenotice'] = 'Remove a line by setting "name" to an empty value.';
$string['conditions:patternparameters'] = 'Parameter patterns';
$string['conditions:patternscriptnames'] = 'Scriptname patterns';

$string['c_r'] = 'Relation conditions <=> rules';

$string['experience:cantrigger'] = 'Can trigger experience';

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
<a href="https://docs.moodle.org/38/en/Embedded_Answers_(Cloze)_question_type" target="_blank">read more</a>';
$string['injecttext:page-question-type-ddwtos'] = '<p>Add the question to the text editor, using any formatting you wish. Use double square brackets \'[[n]]\' with a number in place of the word you wish the students to find.</p>
<a href="https://docs.moodle.org/38/en/Drag_and_drop_into_text_question_type" target="_blank">read more</a>';
$string['injecttext:page-question-type-wordselect'] = '<p>This question type is designed to ask students to select text according to some criteria. For example "select the verb in the following sentence". Conceptually this is a little like a multiple choice question type (with multiple selectable options). The student responds by clicking on words to select them, and clicking a second time to unselect them.</p>
<p>It provides an introduction field where words will not be selectable at runtime and a questiontext field. In the question text any words with braces around them will be considered correct. All words can be clicked-on to select.</p>
<a href="https://docs.moodle.org/38/en/Wordselect_question_type" target="_blank">read more</a>';
$string['injecttext:page-mod-bigbluebuttonbn-mod'] = 'The <a href="https://www.lernmanagement.at" target="_blank">Center for Learning Management</a> provides the open source video conferencing software <a href="https://bigbluebutton.org" target="_blank">BigBlueButton</a> in a basic version for up to 1000 simultaneous users. BBB tariffs with higher or guaranteed bandwidth can be obtained from various providers for a fee.';
$string['injecttext:page-mod-bigbluebuttonbn-mod:readmore'] = '[<a href="{$a->wwwroot}/local/experience/pages/bigbluebutton.php" target="_blank">learn more</a>]';
$string['injecttext:page-mod-bigbluebuttonbn-mod:longtext'] = '<p>In order to be able to quickly switch to a more powerful, chargeable BBB server in the event of a crisis, we have put together 3 providers as examples. If an external service provider is chosen, a contract must be concluded between the provider and the school. In Eduvidual an alternative BBB server can be entered via the management interface. If you have any questions please contact <a href="mailto:rene.schwarzinger@lernmanagement.at?subject=BigBlueButton">rene.schwarzinger@lernmanagement.at</a>!</p>

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
