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

// Keep these functions until we can safely uninstall and reinstall plugin.
function local_experience_before_http_headers() {}
function local_experience_before_standard_top_of_body_html()  {}


function local_experience_before_standard_html_head() {
    global $CFG, $DB, $PAGE;

    if (has_capability('local/experience:cantrigger', $PAGE->context)) {
        // Show trigger and add basic functionality.
        $PAGE->requires->css('/local/experience/style/main.css');
        $PAGE->requires->css('/local/experience/style/switch.css');
        $PAGE->requires->js_call_amd("local_experience/main", "injectText", array());

        // We only process rules that set default values when we add new things.
        // Determine if there are any rules for the current page.
        $scriptname = str_replace($CFG->dirroot, "", $_SERVER["SCRIPT_FILENAME"]);
        $sql = "SELECT *
                    FROM {local_experience_conditions}
                    WHERE patternscriptnames LIKE ?
                        OR patternscriptnames='*'";
        $conditions = $DB->get_records_sql($sql, array($scriptname));
        $applyconditions = array();
        foreach ($conditions AS $condition) {
            $params = explode('&', $condition->patternparameters);
            $isok = true;
            foreach ($params AS $param) {
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
            foreach ($rules AS $rule) {
                $allrules[] = $rule;
            }
        }
        $PAGE->requires->js_call_amd("local_experience/main", "applyRules", array($level, $allrules));
        $containers = get_config('local_experience', 'attachlevelselectto');
        $PAGE->requires->js_call_amd("local_experience/main", "injectButton", array($level, $containers));
    }

    return "";
}

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
    }
}
/**
 * Extend navigation.
 */
function local_experience_extend_navigation_frontpage($parentnode) {
    // @TODO add a button somehow to toggle between advanced and basic mode.
}
