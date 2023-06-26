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
 * @copyright  2018 Digital Education Society (http://www.dibig.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/local/experience/locallib.php');

function local_experience_after_config() {
    global $CFG;
    $scripts = array(
        '/course/dndupload.php',
    );
    $script = str_replace($CFG->dirroot, '', $_SERVER["SCRIPT_FILENAME"]);
    if (in_array($script, $scripts)) {
        \local_experience\lib_wshelper::buffer();
    }
}

function local_experience_before_http_headers() {
    global $PAGE;
    if (has_capability('local/experience:cantrigger', $PAGE->context)) {
        $level = get_user_preferences('local_experience_level', 0);
        $PAGE->add_body_class('local-experience-level-' . $level);
    }
}

function local_experience_before_standard_html_head() {
    global $CFG, $DB, $PAGE, $OUTPUT;

    $html = '';

    if (strpos($_SERVER["SCRIPT_FILENAME"], '/course/modedit.php') > 0) {
        $add = optional_param('add', '', PARAM_ALPHANUM);
        if (!empty($add)) {
            $enabled = \get_config('local_experience', 'auto_set_completion_details');
            $plusdays = \get_config('local_experience', 'auto_set_completion_add_days');
            if (!empty($enabled) && !empty($plusdays)) {
                $PAGE->requires->js_call_amd("local_experience/main", "setCompletionDefaults", array($plusdays));
            }
        }
    }

    $PAGE->requires->css('/local/experience/style/main.css');
    $PAGE->requires->css('/local/experience/style/switch.css');
    $PAGE->requires->js_call_amd("local_experience/main", "injectText", array());

    if (has_capability('local/experience:cantrigger', $PAGE->context)) {
        // Show trigger and add basic functionality.
        if ($PAGE->user_allowed_editing()) {
            $PAGE->requires->js_call_amd("local_experience/main", "captureKeycode", array());
        }

        // We only process rules that set default values when we add new things.
        // Determine if there are any rules for the current page.
        $scriptname = str_replace($CFG->dirroot, "", $_SERVER["SCRIPT_FILENAME"]);
        $sql = "SELECT *
                    FROM {local_experience_conditions}
                    WHERE patternscriptnames LIKE ?
                        OR patternscriptnames='*'";
        $conditions = $DB->get_records_sql($sql, array($scriptname));
        $applyconditions = array();
        foreach ($conditions as $condition) {
            $params = explode('&', $condition->patternparameters);
            $isok = true;
            foreach ($params as $param) {
                $pair = explode('=', $param);
                if (count($pair) == 2 && optional_param($pair[0], '', PARAM_RAW) != $pair[1]) {
                    $isok = false;
                }
            }
            if ($isok) {
                $applyconditions[] = $condition->id;
            }
        }

        // Set all rules according to our level.
        $level = get_user_preferences('local_experience_level', 0);
        $allrules = array();
        if (count($applyconditions) > 0) {
            $sql = "SELECT r.id,r.*
                        FROM {local_experience_rules} r, {local_experience_c_r} cr
                        WHERE cr.conditionid IN (" . implode(',', $applyconditions) . ")
                            AND cr.ruleid=r.id
                        ORDER BY r.sort ASC";
            $rules = $DB->get_records_sql($sql, array());
            foreach ($rules as $rule) {
                $allrules[] = $rule;
            }
        }
        $PAGE->requires->js_call_amd("local_experience/main", "applyRules", array($level, $allrules));
        //$containers = get_config('local_experience', 'attachlevelselectto');
        //$PAGE->requires->js_call_amd("local_experience/main", "injectButton", array($level, $containers));
    }

    $injectquestion = optional_param('local_experience_injectquestion', '', PARAM_TEXT);
    if (!empty($injectquestion)) {
        $x = explode(':', $injectquestion);
        if (count($x) == 3) {
            $html .= $OUTPUT->render_from_template('local_experience/overlay', []);
            $PAGE->requires->js_call_amd("local_experience/main", "injectQuestionTemplate", array($x[0], $x[1], $x[2]));
        }
    }

    $html .= $OUTPUT->render_from_template('local_experience/html_head', [
        'experience_switch' => [
            'cantrigger' => has_capability('local/experience:cantrigger', $PAGE->context),
            'checked' => get_user_preferences('local_experience_level', 0) == 1,
        ],
    ]);


    return $html;
}

function local_experience_before_standard_top_of_body_html() {
    global $CFG, $DB, $OUTPUT, $PAGE;
    $html = "";
    /*
    if (has_capability('local/experience:cantrigger', $PAGE->context)) {
        $level = get_user_preferences('local_experience_level', 0);
        $html = $OUTPUT->render_from_template('local_experience/trigger', array('ison' => $level));
        $PAGE->requires->js_call_amd("local_experience/main", "detectModification", array());
    }
    */

    return $html;
}

/*
function local_experience_extend_navigation($navigation) {
    global $PAGE;
    if (has_capability('local/experience:cantrigger', $PAGE->context)) {
        $nodehome = $navigation->add('test', '', navigation_node::NODETYPE_BRANCH, '', 'experiencelevelbranch'); //$navigation->get('home');
        $level = get_user_preferences('local_experience_level', 0);
        $label = get_string('advanced_options', 'local_experience');
        $link = '#';
        $icon = null;
        $nodecreatecourse = $nodehome->add($label, $link, navigation_node::NODETYPE_LEAF, $label, 'experiencelevel', $icon);
        $nodecreatecourse->showinflatnavigation = true;
        $level = get_user_preferences('local_experience_level', 0);
        $PAGE->requires->js_call_amd("local_experience/main", "enablePanelTrigger", array($level));
    }
}
*/

/**
 * Extend navigation.
 */
function local_experience_extend_navigation_frontpage($parentnode) {
    // @TODO add a button somehow to toggle between advanced and basic mode.
}
